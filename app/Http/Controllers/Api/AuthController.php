<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SendNotif;
use Validator, RestApi, JWTAuth, Mail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as ProviderUser;

class AuthController extends Controller
{
    public function loginGoogle(Request $request, $provider) {
        $accessToken = $request->accessToken;
        
        try {
            $oauthUser = Socialite::driver($provider)->stateless()->userFromToken($accessToken);
        } catch (\Exception $exception) {
            return $exception;
        }
        
        if (isset($oauthUser->id)) {
            $user = $this->findOrCreate($oauthUser, $provider);
            $token = JWTAuth::fromUser($user);
            return RestApi::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires' => (strtotime(date('Y-m-d H:i:s')) + (JWTAuth::factory()->getTTL() * 60)),
                'user' => $user
            ], 200, 'Authentication success.');
        }
  
        return RestApi::error([
            'error' => 'Authentication failed.'
        ], 401, 'Authentication failed.');
    }
  
    protected function findOrCreate(ProviderUser $providerUser) {
      $user = User::where('email', $providerUser->email)->first();
      if (isset($user->id)) {
        return $user;
      } else {
        $user = null;
  
        if ($email = $providerUser->getEmail()) {
          $user = User::where('email', $email)->first();
        }
  
        if (!$user) {
          $user = User::create([
            'name' => $providerUser->getName(),
            'email' => $providerUser->getEmail(),
            'oauth_id'=> $providerUser->id,
            'level' => 'user'
          ]);
        }
  
        return $user;
      }
    }

    public function checkCredentials(Request $request)
    {
        $rules = [
            'auth' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $credentials = $request->auth;

        if (filter_var($credentials, FILTER_VALIDATE_EMAIL)) {
            $check = User::where('email', $credentials)->first();

            if (!isset($check->id)) {
                return RestApi::error('Email tidak terdaftar.', 400);
            }

            if (isset($check->id) && $check->active == '0') {
                return RestApi::error('Akun belum aktif. Silakan selesaikan pendaftaran.', 400);
            }

            return RestApi::success([
                    'login_type' => 'email',
                    'email' => $credentials
                ], 200, 'Check Credentials success.');

        } else if(strlen($credentials) >= 10) {

            $phone = $this->parsePhone($credentials);

            $check = User::where('phone', $phone)->first();

            if (!isset($check->id)) {
                return RestApi::error('Nomor tidak terdaftar.', 400);
            }

            if (isset($check->id) && $check->active == '0') {
                return RestApi::error('Akun belum aktif. Silakan selesaikan pendaftaran.', 400);
            }

            return RestApi::success([
                    'login_type' => 'phone',
                    'phone' => $phone
                ], 200, 'Check Credentials success.');
        } else {
            return RestApi::error('Email/No. HP tidak terdaftar.', 400);
        }
    }

    public function login(Request $request)
    {
        
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $credentials = $request->only('email', 'password');
        
        try {
            if ($token = JWTAuth::attempt($credentials)) {
                $user = User::find(JWTAuth::user()->id);
                return RestApi::success([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'expires' => (strtotime(date('Y-m-d H:i:s')) + (JWTAuth::factory()->getTTL() * 60)),
                    'user' => $user
                ], 200, 'Authentication success.');
            }

        	return RestApi::error('Nama Pengguna atau Kata Sandi Salah.', 404);
        } catch (JWTException $e) {
        	return RestApi::error('Sesuatu error terjadi.', 500);
        }
    }

    public function getOtp(Request $request)
    {
        $rules = [
            'phone' => 'required',
        ];

        $request['phone'] = $this->parsePhone($request->phone);


        if(!isset($request->phone) || strlen($request->phone) < 10) {
            return RestApi::error('Masukkan nomor dengan benar!', 400);
        }

        if(substr($request->phone, 0, 2) != '08') {
            return RestApi::error('Wajib menggunakan nomor Indonesia!', 400);
        }
        
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        

        $phone = $this->parsePhone($request->phone);
        $otp = \AppHelper::generateOTP(6);

        $check = User::where('phone', $phone)->first();

        if(isset($check->id) && $check->active == '0') {
            return RestApi::error('Akun belum aktif. Silakan selesaikan pendaftaran.', 400);
        }

        if (!isset($check->id)) {
            return RestApi::error('Nomor tidak terdaftar.', 400);
        } else if(isset($check->id)) {

            if(strtotime('-90 second', $check->otp_expire) >= strtotime('now')) {
                $wait = (intval(strtotime('-90 second', $check->otp_expire)) - intval(strtotime('now')));
                return RestApi::error('Tunggu '.$wait.' detik.', 400, ['resend_time' => $wait]);
            }

            $check->otp = $otp;
            $check->otp_expire = strtotime('+2 minutes');

            if(!$check->update()){
                return RestApi::error('Sesuatu error terjadi.', 500);
            }
        }else{
            return RestApi::error('Silakan login dengan username dan password.', 500);
        }

        // $data = [
        //     'ApiKey'    => getEnv('WA_KEY'),
        //     'Phone'     => $phone,
        //     'Message'   => str_replace('$DATE$', date('d-m-Y H:i:s', strtotime('+2 minutes')), str_replace('\n', PHP_EOL, str_replace('$OTP$', $otp, getEnv('WA_MESSAGE'))))
        // ];


        $response = SendNotif::send($request->phone, 'Kode OTP Anda adalah '. $otp .'. Kode ini berlaku dalam 2 menit. RAHASIAKAN kode Anda. Abaikan Jika Anda tidak meminta kode verifikasi ini.');
        // $client = new \GuzzleHttp\Client();

        // try {
        //     $response = $this->request('POST', getEnv('WA_URL').'v5/send', $data);
        // } catch (\GuzzleHttp\Exception\ClientException $e) {
        //     $response = $e->getResponse();
        // } catch (\GuzzleHttp\Exception\RequestException $e) {
        //     $response = $e->getResponse();
        // }

        // 'date_now' => date('Y-m-d H:i:s'),
        // 'date_valid' => date('Y-m-d H:i:s', strtotime('+2 minutes')),
        // 'valid_for' => strtotime('+2 minutes'),

        if ($response['code'] == 200 && $response['status']) {
            return RestApi::success([
                'resend_time' => 120,
                'phone' => $phone,
                'message' => 'Berhasil mengirim Kode OTP.',
                'type' => 'otp',
            ], 200, 'Send OTP success.');
        }else{
            return RestApi::error('Gagal mengirim Kode OTP.', $response['code']);
        }
    }

    public function checkOtp(Request $request)
    {
        $rules = [
            'phone' => 'required',
            'otp' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $phone  = $this->parsePhone($request->phone);
        $otp    = $request->otp;

        $user = User::where('phone', $phone)->first();

        if(!isset($user->id) || !isset($user->otp) || !isset($user->otp_expire)) {
            return RestApi::error('Nomor tidak ditemukan.', 404);
        }

        if(isset($user->id) && $user->active == '0') {
            return RestApi::error('Akun belum aktif. Silakan selesaikan pendaftaran.', 404);
        }

        if(isset($user->otp) && $user->otp == $otp) {
            if(isset($user->otp_expire) && $user->otp_expire >= strtotime('now')) {

                $user->otp = null;
                $user->otp_expire = null;
                $user->update();

                $token = JWTAuth::fromUser($user);
                return RestApi::success([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'expires' => (strtotime(date('Y-m-d H:i:s')) + (JWTAuth::factory()->getTTL() * 60)),
                    'user' => $user
                ], 200, 'Authentication success.');
            }else{
                return RestApi::error('Kode OTP telah berakhir.', 400);
            }
        }else{
            return RestApi::error('Kode OTP tidak benar.', 400);
        }
    }

    public function refresh()
    {
        if ($token = JWTAuth::refresh(JWTAuth::getToken())) {
        	return RestApi::success([
	        	'access_token' => $token,
                'token_type' => 'Bearer',
	        	'expires' => (strtotime(date('Y-m-d H:i:s')) + (JWTAuth::factory()->getTTL() * 60))
	        ], 200, 'Refresh token success.');
        }
        return RestApi::error('Sesuatu error terjadi.', 401);
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->bearerToken());
            return RestApi::success([
                'message' => 'Berhasil logout.'
            ], 200, 'Refresh token success.');
        } catch (JWTException $e) {
            return RestApi::error('Sesuatu error terjadi.', 401);
        }
    }

    public function user(Request $request)
    {
        $user = User::find(JWTAuth::user()->id);
        $user->topics;
        if (!isset($user->id)) {
            return RestApi::error('User tidak ditemukan.', 404);
        }
        return RestApi::success([
            'user' => $user
        ], 200);
    }

    // REGISTER

    public function register(Request $request) {
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'jenis' => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $credentials = $request->only('name', 'email', 'password', 'jenis', 'phone');
        $credentials['level'] = 'user';
        $credentials['active'] = '1';
        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);

        if ($user) {
            return RestApi::success([
                'status' => 'success',
                'message' => 'Berhasil mendaftar.'
            ], 200);
        } else {
            return RestApi::error('Gagal mendaftar.', 400);
        }
    }

    public function getOtpRegister(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'phone' => 'unique:users,phone',
        ];

        $request['phone'] = $this->parsePhone($request->phone);

        if(!isset($request->phone) || strlen($request->phone) < 10) {
            return RestApi::error('Masukkan nomor dengan benar!', 400);
        }

        if(substr($request->phone, 0, 2) != '08') {
            return RestApi::error('Wajib menggunakan nomor Indonesia!', 400);
        }
        
        $user = User::where('phone', $request->phone)->first();

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            if(isset($user->id) && $user->active == '0') {

            }else{
                return RestApi::error($validator->messages()->first(), 400);
            }
        }

        if(isset($user->id) && $user->active == '0') {
            $user->name = $request->name;
            $user->update();
        }else{
            $credentials = $request->only('name', 'phone');
            $credentials['level'] = 'user';
            $credentials['active'] = '0';
            $user = User::create($credentials);
        }

        $phone = $this->parsePhone($request->phone);
        $otp = \AppHelper::generateOTP(6);

        $check = User::where('phone', $phone)->where('active', '0')->first();

        if (!isset($check->id)) {
            return RestApi::error('Nomor tidak ditemukan.', 400);
        } else if(isset($check->id)) {

            if(strtotime('-90 second', $check->otp_expire) >= strtotime('now')) {
                $wait = (intval(strtotime('-90 second', $check->otp_expire)) - intval(strtotime('now')));
                return RestApi::error('Tunggu '.$wait.' detik.', 400, ['resend_time' => $wait]);
            }

            $check->otp = $otp;
            $check->otp_expire = strtotime('+2 minutes');

            if(!$check->update()){
                return RestApi::error('Sesuatu error terjadi.', 500);
            }
        }else{
            return RestApi::error('Sesuatu error terjadi.', 500);
        }

        $response = SendNotif::send($request->phone, 'Kode OTP Anda adalah '. $otp .'. Kode ini berlaku dalam 2 menit. RAHASIAKAN kode Anda. Abaikan Jika Anda tidak meminta kode verifikasi ini.');


        // $data = [
        //     'ApiKey'    => getEnv('WA_KEY'),
        //     'Phone'     => $phone,
        //     'Message'   => str_replace('$DATE$', date('d-m-Y H:i:s', strtotime('+2 minutes')), str_replace('\n', PHP_EOL, str_replace('$OTP$', $otp, getEnv('WA_MESSAGE'))))
        // ];

        // $client = new \GuzzleHttp\Client();

        // try {
        //     $response = $this->request('POST', getEnv('WA_URL').'v5/send', $data);
        // } catch (\GuzzleHttp\Exception\ClientException $e) {
        //     $response = $e->getResponse();
        // } catch (\GuzzleHttp\Exception\RequestException $e) {
        //     $response = $e->getResponse();
        // }

        if ($response['code'] == 200 && $response['status']) {
            return RestApi::success([
                'resend_time' => 120,
                'phone' => $phone,
                'message' => 'Berhasil mengirim Kode OTP.',
                'type' => 'otp',
            ], 200, 'Send OTP success.');
        }else{
            return RestApi::error('Gagal mengirim Kode OTP.', $response['code']);
        }
    }

    public function checkOtpRegister(Request $request)
    {
        $rules = [
            'phone' => 'required',
            'otp' => 'required|min:6|max:6',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $phone  = $this->parsePhone($request->phone);
        $otp    = $request->otp;
        $email    = $request->email;

        $user = User::where(['phone' => $phone, 'active' => '0'])->first();

        if(!isset($user->id)) {
            return RestApi::error('Nomor tidak ditemukan.', 404);
        }

        if(isset($user->otp) && $user->otp == $otp) {
            if(isset($user->otp_expire) && $user->otp_expire >= strtotime('now')) {

                $user->otp = null;
                $user->otp_expire = null;
                $user->update();

                $token = JWTAuth::fromUser($user);
                return RestApi::success([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'expires' => (strtotime(date('Y-m-d H:i:s')) + (JWTAuth::factory()->getTTL() * 60)),
                    'user' => $user
                ], 200, 'Authentication success.');
            }else{
                return RestApi::error('Kode OTP telah berakhir.', 400);
            }
        }else{
            return RestApi::error('Kode OTP tidak benar.', 400);
        }
    }

    public function checkOtpOauth(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'otp' => 'required|min:6|max:6',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $otp    = $request->otp;
        $email    = $request->email;

        $user = User::where(['email' => $email, 'active' => '0'])->first();

        if(!isset($user->id)) {
            return RestApi::error('Email tidak ditemukan.', 404);
        }

        if(isset($user->otp) && $user->otp == $otp) {
            if(isset($user->otp_expire) && $user->otp_expire >= strtotime('now')) {

                $user->otp = null;
                $user->otp_expire = null;
                $user->update();

                $token = JWTAuth::fromUser($user);
                return RestApi::success([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'expires' => (strtotime(date('Y-m-d H:i:s')) + (JWTAuth::factory()->getTTL() * 60)),
                    'user' => $user
                ], 200, 'Authentication success.');
            }else{
                return RestApi::error('Kode OTP telah berakhir.', 400);
            }
        }else{
            return RestApi::error('Kode OTP tidak benar.', 400);
        }
    }

    public function checkEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!isset($user->id)) {
            return RestApi::success('Email belum digunakan.', 200);
        } else if (isset($user->id) && !is_null($user->oauth_id)) {
            return RestApi::success('Email bisa digunakan', 200);
        }

        $rules = [
            'email' => 'required|unique:users,email',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }
    }

    public function checkNik(Request $request)
    {
        $rules = [
            'nik' => 'required|unique:users,nik|min:16|max:16',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $user = User::where('nik', $request->nik)->first();

        if (!isset($user->id)) {
            return RestApi::success('NIK belum digunakan.', 200);
        }
    }

    public function updateInfoRegister(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required|min:6|confirmed',
            'jenis' => 'required|in:UKM,KOPERASI,INSTANSI,UMUM',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $user = User::find(JWTAuth::user()->id);

        if(!isset($user->id)) {
            return RestApi::error('User tidak ditemukan', 404);
        }

        if($user->active == '1') {
            return RestApi::error('User telah melengkapi pendaftaran.', 400);
        }

        $user->name = $request->name;
        if (!isset($user->email)) {
            $user->email = $request->email;
        }
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->jenis = $request->jenis;
        $user->active = '1';

        if($user->update()) {
            return RestApi::success('Berhasil update user.', 200);
        }
    }

    // END REGISTER

    // END AUTHENTICATION //

    // START FORGOT PASSWORD //

    public function forgotPassword(Request $request)
    {
        $rules = [
            'phone' => 'required',
        ];

        $request['phone'] = $this->parsePhone($request->phone);

        if(!isset($request->phone) || strlen($request->phone) < 10) {
            return RestApi::error('Masukkan nomor dengan benar!', 400);
        }

        if(substr($request->phone, 0, 2) != '08') {
            return RestApi::error('Wajib menggunakan nomor Indonesia!', 400);
        }

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $phone = $this->parsePhone($request->phone);
        $otp = \AppHelper::generateOTP(6);


        $check = User::where('phone', $phone)->first();

        if (!isset($check->id)) {
            return RestApi::error('Nomor belum terdaftar.', 500);
        } else if (isset($check->id) && $check->active == '0') {
            return RestApi::error('Selesaikan proses pendaftaran.', 500);
        } else {

            $check->otp = $otp;
            $check->otp_expire = strtotime('+2 minutes');

            if(!$check->update()){
                return RestApi::error('Sesuatu error terjadi.', 500);
            }
        }

        $response = SendNotif::send($request->phone, 'Kode OTP Anda adalah '. $otp .'. Kode ini berlaku dalam 2 menit. RAHASIAKAN kode Anda. Abaikan Jika Anda tidak meminta kode verifikasi ini.');

        
        // $data = [
        //     'ApiKey'    => getEnv('WA_KEY'),
        //     'Phone'     => $phone,
        //     'Message'   => str_replace('$DATE$', date('d-m-Y H:i:s', strtotime('+2 minutes')), str_replace('\n', PHP_EOL, str_replace('$OTP$', $otp, getEnv('WA_MESSAGE'))))
        // ];

        // $client = new \GuzzleHttp\Client();

        // try {
        //     $response = $this->request('POST', getEnv('WA_URL').'v5/send', $data);
        // } catch (\GuzzleHttp\Exception\ClientException $e) {
        //     $response = $e->getResponse();
        // } catch (\GuzzleHttp\Exception\RequestException $e) {
        //     $response = $e->getResponse();
        // }

        if ($response['code'] == 200 && $response['status']) {
            return RestApi::success([
                'resend_time' => 120,
                'phone' => $phone,
                'message' => 'Berhasil mengirim Kode OTP.',
                'type' => 'otp',
            ], 200, 'Send OTP success.');
        }else{
            return RestApi::error('Gagal mengirim Kode OTP.', $response['code']);
        }
    }

    public function forgotCheck(Request $request)
    {
        $rules = [
            'phone' => 'required',
            'otp' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $phone  = $this->parsePhone($request->phone);
        $otp    = $request->otp;

        $user = User::where('phone', $phone)->first();

        if(!isset($user->id) || !isset($user->otp) || !isset($user->otp_expire)) {
            return RestApi::error('Nomor tidak ditemukan.', 404);
        }

        if(isset($user->otp) && $user->otp == $otp) {
            if(isset($user->otp_expire) && $user->otp_expire >= strtotime('now')) {

                $user->otp = null;
                $user->otp_expire = null;
                $user->update();

                $token = JWTAuth::fromUser($user);
                return RestApi::success([
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'expires' => (strtotime(date('Y-m-d H:i:s')) + (JWTAuth::factory()->getTTL() * 60))
                ], 200, 'Authentication success.');
            }else{
                return RestApi::error('Kode OTP telah berakhir.', 400);
            }
        }else{
            return RestApi::error('Kode OTP tidak benar.', 400);
        }
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'password' => 'required|string|confirmed|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $user = User::find(JWTAuth::user()->id);

        if(!isset($user->id)) {
            return RestApi::error('User tidak ditemukan.', 404);
        }

        $user->password = bcrypt($request->password);

        if ($user->update()) {

            try {
                JWTAuth::invalidate($request->bearerToken());
                $token = JWTAuth::fromUser($user);
                return RestApi::success('Berhasil mengubah password.', 200, 'Berhasil mengubah password.');
            } catch (JWTException $e) {
                return RestApi::error('Sesuatu error terjadi.', 500);
            }
            
        }else{
            return RestApi::error('Sesuatu error terjadi.', 500);
        }
    }

    // END FORGOT PASSWORD //

    // START PRIVATE FUNCTION //

    private function request($method='GET', $url=null, $data=[], $headers=[])
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request($method, $url, [
                        'json' => $data,
                        'headers' => array_merge([
                            'User-Agent' => 'LekJukiApp/'.date('Y'),
                        ], $headers)
                    ]);

        return $response;
    }

    private function parsePhone($number=null)
    {
        if($number == null) {
            return $number;
        }

        $number = str_replace(" ","",$number);
        $number = str_replace("'","",$number);
        $number = str_replace("\"","",$number);
        $number = str_replace("-","",$number);
        $number = str_replace("(","",$number);
        $number = str_replace("*","",$number);
        $number = str_replace("^","",$number);
        $number = str_replace(")","",$number);
        $number = str_replace(".","",$number);
        $number = str_replace(",","",$number);
        $number = str_replace("/","",$number);
        $number = str_replace("?","",$number);

        $number = preg_replace('/[a-z]/i', '', $number);
        // dd($number);
        preg_match_all('!\d+!', $number, $no);
        $no = $no[0][0];


        $phone = null;


        // 0 TO 62
     //     if(substr(trim($no), 0, 2)=='62'){
     //     $phone = trim($no);
     //     }elseif(substr(trim($no), 0, 1)=='0'){
     //     $phone = '62'.substr(trim($no), 1);
        // }elseif(substr(trim($no), 0, 1)=='+'){
     //     $phone = substr(trim($no), 1);
        // }

        // 62 TO 0
        if(substr(trim($no), 0, 1)=='0'){
            $phone = trim($no);
        }elseif(substr(trim($no), 0, 2)=='62'){
            $phone = '0'.substr(trim($no), 2);
        }elseif(substr(trim($no), 0, 3)=='+62'){
            $phone = '0'.substr(trim($no), 3);
        }

        return $phone;
    }
}
