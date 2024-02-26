<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class OauthController extends Controller {
  public function redirect($provider) {
    return response()->json([
      'url' => Socialite::driver($provider)->with(['redirect_uri' => getenv('OAUTH_GOOGLE_REDIRECT_URI')])->stateless()->redirect()->getTargetUrl(),
    ]);
    // return Socialite::driver($provider)->redirect();
  }

  public function callback($provider) {

    $oauthUser = Socialite::driver($provider)->stateless()->user();
    $user = User::where('email', $oauthUser->email)->first();
    if (isset($user->id)) {
      if ($user->active) {
        return view('oauth/login', [
          'status' => true,
          'token' => JWTAuth::fromUser($user),
        ]);
      } else {
        $otp = \AppHelper::generateOTP(6);
        $user->otp = $otp;
        $user->otp_expire = strtotime('+2 minutes');
        $user->update();
        return view('oauth/register', [
          'status' => true,
          'otp' => $otp,
          'email' => $user->email,
          'name' => $user->name
        ]);
      }
    } else {
      $newUser = User::create([
          'name' => $oauthUser->name,
          'email' => $oauthUser->email,
          'oauth_id'=> $oauthUser->id,
          'level' => 'user'
      ]);
      $otp = \AppHelper::generateOTP(6);
      $newUser->otp = $otp;
      $newUser->otp_expire = strtotime('+2 minutes');
      $newUser->update();
      return view('oauth/register', [
          'status' => true,
          'otp' => $otp,
          'email' => $newUser->email,
          'name' => $newUser->name
        ]);
    }
  }
}