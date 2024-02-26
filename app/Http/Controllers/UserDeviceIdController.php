<?php

namespace App\Http\Controllers;

use App\Models\UserDeviceId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\RestApi;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserDeviceIdController extends Controller {
    public function create (Request $request) {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $user = User::find(JWTAuth::user()->id);
        $userDeviceId = UserDeviceId::firstOrCreate([
            'device_id' => $request->device_id,
            'user_id' => $user->id,
        ]);

        if ($userDeviceId) {
            return RestApi::success('Berhasil menambahkan device id', 200);
        }
    }
}
