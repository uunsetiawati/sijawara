<?php

namespace App\Http\Controllers;

use RestApi, Validator, JWTAuth;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function course(Request $request)
    {
    	$rules = [
    		'course' => 'required',
    	];

    	$validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = \App\Models\Course::findByUuid($request->course);

        if(!isset($course->id)) {
            return RestApi::error('Kursus tidak ditemukan.', 404);
        }

        $user = \App\Models\User::find(JWTAuth::user()->id);

        if(!isset($user->id)) {
            return RestApi::error('User tidak ditemukan.', 404);
        }

        $courseSection = \App\Models\CourseSection::where(['user_id' => $user->id, 'course_id' => $course->id])->orderBy('id', 'DESC')->first();

        if(!isset($courseSection->id)) {
            return RestApi::error('Belum bergabung pada kursus.', 404);
        }

        if($courseSection->nilai < 75) {
            return RestApi::error('Nilai anda dibawah rata - rata.', 404);
        }

    	return RestApi::success(['url' => url('certificate/course/'.$course->uuid.'/'.base64_encode($courseSection->uuid).'/download')]);
    }

    public function online(Request $request)
    {
    	$rules = [
    		'course' => 'required',
    	];

    	$validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

    	$course = \App\Models\CourseOther::findByUuid($request->course);

        if(!isset($course->id)) {
            return RestApi::error('Kursus tidak ditemukan.', 404);
        }

        $user = \App\Models\User::find(JWTAuth::user()->id);

        if(!isset($user->id)) {
            return RestApi::error('User tidak ditemukan.', 404);
        }

        $courseSection = \App\Models\CourseSection::where(['user_id' => $user->id, 'course_other_id' => $course->id])->orderBy('id', 'DESC')->first();

        if(!isset($courseSection->id)) {
            return RestApi::error('Belum bergabung pada kursus.', 404);
        }

        if($courseSection->no_urut == null) {
            $QN = \App\Models\CourseSection::whereNotNull('course_other_id')->whereYear('created_at', date('Y'))->orderBy('no_urut', 'DESC')->first();
            if(isset($QN->id) && $QN->no_urut != null) {
                $no_urut = $QN->no_urut+1;
            }else{
                $no_urut = 1;
            }
            $courseSection->update(['no_urut' => $no_urut]);

        }

        return RestApi::success(['urut' => $courseSection->no_urut, 'url' => url('certificate/online/'.$course->uuid.'/'.base64_encode($courseSection->uuid).'/download')]);
    }

    public function offline(Request $request)
    {
    	$rules = [
            'course' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = \App\Models\CourseOther::findByUuid($request->course);

        if(!isset($course->id)) {
            return RestApi::error('Kursus tidak ditemukan.', 404);
        }

        $user = \App\Models\User::find(JWTAuth::user()->id);

        if(!isset($user->id)) {
            return RestApi::error('User tidak ditemukan.', 404);
        }

        $courseSection = \App\Models\CourseSection::where(['user_id' => $user->id, 'course_other_id' => $course->id])->orderBy('id', 'DESC')->first();

        if(!isset($courseSection->id)) {
            return RestApi::error('Belum bergabung pada kursus.', 404);
        }

        if($courseSection->no_urut == null) {
            $QN = \App\Models\CourseSection::whereNotNull('course_other_id')->whereYear('created_at', date('Y'))->orderBy('no_urut', 'DESC')->first();
            if(isset($QN->id) && $QN->no_urut != null) {
                $no_urut = $QN->no_urut+1;
            }else{
                $no_urut = 1;
            }
            $courseSection->update(['no_urut' => $no_urut]);

        }

        return RestApi::success(['urut' => $courseSection->no_urut, 'url' => url('certificate/online/'.$course->uuid.'/'.base64_encode($courseSection->uuid).'/download')]);
    }

    public function courseDownload(Request $request, $course_uuid, $section_uuid)
    {
        $course = \App\Models\Course::findByUuid($course_uuid);

        if(!isset($course->id)) {
            // return RestApi::error('Kursus tidak ditemukan.', 404);
            abort(404);
            return;
        }

        $courseSection = \App\Models\CourseSection::findByUuid(base64_decode($section_uuid), 'User', 'Course');
        if(!isset($courseSection->id)) {
            abort(404);
            return;
        }
        $image = storage_path('app/public/ecert.png');
        $pdf = \PDF::loadView('pdf.ecert', compact('image', 'courseSection'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('E-CERTIFICATE_SIJAWARA_'.strtoupper(str_slug($course->nm_course)).'_'.strtoupper(str_slug($courseSection->User->name)).'.pdf');
        // return $pdf->stream();
    }

    public function onlineDownload(Request $request, $course_uuid, $section_uuid)
    {
        $no_urut = '001';
        $course = \App\Models\CourseOther::findByUuid($course_uuid);

        if(!isset($course->id)) {
            // return RestApi::error('Kursus tidak ditemukan.', 404);
            abort(404);
            return;
        }
        $courseSection = \App\Models\CourseSection::findByUuid(base64_decode($section_uuid), 'User', 'CourseOther');
        if(!isset($courseSection->id)) {
            abort(404);
            return;
        }
        $tanggal = '2021-01-01';
        $image = storage_path('app/public/cert.png');
        $pdf = \PDF::loadView('pdf.cert', compact('image', 'no_urut', 'courseSection'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('CERTIFICATE_SIJAWARA_'.strtoupper(str_slug($course->title)).'_'.strtoupper(str_slug($courseSection->User->name)).'.pdf');
        // return $pdf->stream();
    }

    public function offlineDownload(Request $request, $course_uuid, $section_uuid)
    {
        $no_urut = '001';
        $course = \App\Models\CourseOther::findByUuid($course_uuid);

        if(!isset($course->id)) {
            // return RestApi::error('Kursus tidak ditemukan.', 404);
            abort(404);
            return;
        }
        $courseSection = \App\Models\CourseSection::findByUuid(base64_decode($section_uuid), 'User', 'CourseOther');
        if(!isset($courseSection->id)) {
            abort(404);
            return;
        }
        $tanggal = '2021-01-01';
        $image = storage_path('app/public/cert.png');
        $pdf = \PDF::loadView('pdf.cert', compact('image', 'no_urut', 'courseSection'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('CERTIFICATE_SIJAWARA_'.strtoupper(str_slug($course->title)).'_'.strtoupper(str_slug($courseSection->User->name)).'.pdf');
        // return $pdf->stream();
    }
}
