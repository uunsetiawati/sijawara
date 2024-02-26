<?php

namespace App\Http\Controllers;

use DB, Validator, AppHelper, RestApi, JWTAuth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getDashboard(Request $request)
    {
    	$user_active = \App\Models\User::where('active', '1')->count();
    	$user_pending = \App\Models\User::where('active', '0')->count();
    	$user_percent = (($user_active/($user_active+$user_pending))*100);

    	$course_active = \App\Models\Course::where('status', '1')->count();
    	$course_pending = \App\Models\Course::where('status', '0')->count();
    	$course_percent = (($course_active/((($course_active+$course_pending) != 0) ? ($course_active+$course_pending) : 1))*100);


    	$course_online_active = \App\Models\CourseOther::where('is_online', '1')->where('is_active', '1')->count();
    	$course_online_pending = \App\Models\CourseOther::where('is_online', '1')->where('is_active', '0')->count();
    	$course_online_percent = (($course_online_active/((($course_online_active+$course_online_pending) != 0) ? ($course_online_active+$course_online_pending) : 1))*100);

    	$course_offline_active = \App\Models\CourseOther::where('is_online', '0')->where('is_active', '1')->count();
    	$course_offline_pending = \App\Models\CourseOther::where('is_online', '0')->where('is_active', '0')->count();
    	$course_offline_percent = (($course_offline_active/((($course_offline_active+$course_offline_pending) != 0) ? ($course_offline_active+$course_offline_pending) : 1))*100);

    	$data = [
    		'user' => [
    			'active' => $user_active,
    			'pending' => $user_pending,
    			'percent' => $user_percent,
    		],
    		'course' => [
    			'active' => $course_active,
    			'pending' => $course_pending,
    			'percent' => $course_percent,
    		],
    		'course_online' => [
    			'active' => $course_online_active,
    			'pending' => $course_online_pending,
    			'percent' => $course_online_percent,
    		],
    		'course_offline' => [
    			'active' => $course_offline_active,
    			'pending' => $course_offline_pending,
    			'percent' => $course_offline_percent,
    		],
    	];
    	return RestApi::success($data);
    }

    public function checkJenis()
    {
        $user = \App\Models\User::find(JWTAuth::user()->id);

        if(!isset($user->id)) {
            return RestApi::error('User tidak ditemukan.', 404);
        }

        if(!in_array(strtolower($user->jenis), ['ukm', 'koperasi'])) {
            return RestApi::error('User tidak masuk jenis UKM/Koperasi.');
        }

        switch (strtolower($user->jenis)) {
            case 'koperasi':
                $koperasi = \App\Models\Koperasi::where('user_id', $user->id)->first();
                if(isset($koperasi->id)) {
                    return RestApi::success(['type' => strtolower($user->jenis), 'has_filled' => true]);
                }else{
                    return RestApi::success(['type' => strtolower($user->jenis), 'has_filled' => false]);
                }
                break;

            case 'ukm':
                $ukm = \App\Models\Ukm::where('user_id', $user->id)->first();
                if(isset($ukm->id)) {
                    return RestApi::success(['type' => strtolower($user->jenis), 'has_filled' => true]);
                }else{
                    return RestApi::success(['type' => strtolower($user->jenis), 'has_filled' => false]);
                }
                break;
        }

        return RestApi::error('User tidak masuk jenis UKM/Koperasi.');
    }

		public function checkProfile()
    {
        $user = \App\Models\User::find(JWTAuth::user()->id);

        if(!isset($user->id)) {
            return RestApi::error('User tidak ditemukan.', 404);
        }

        if (is_null($user->address) || 
				is_null($user->birth_date) || 
				is_null($user->birth_place) || 
				is_null($user->city_id) ||
				is_null($user->province_id) ||
				is_null($user->instansi) ||
				is_null($user->jabatan) ||
				is_null($user->nik)) {
					return RestApi::success(['has_filled' => false]);
				}

				return RestApi::success(['has_filled' => true]);
    }
}
