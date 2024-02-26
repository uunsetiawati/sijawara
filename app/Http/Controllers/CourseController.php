<?php

namespace App\Http\Controllers;

use JWTAuth, DB, Validator, AppHelper, RestApi;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Notification;
use App\Models\NotificationTopic;
use App\Models\Topic;

class CourseController extends Controller
{
    public function index(Request $request)
    {
    	if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $course = Course::where(function($q) use ($request) {
                $q->where('nm_course', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $course->map(function($a) {
            	$a->overview = AppHelper::readMore(strip_tags($a->overview), 60);
            	$a->image = '<img src="'.$a->image_url.'" class="img-responsive" style="height: 40px; width: 60px; object-fit: cover;"/>';
                $a->action = '<button class="btn btn-sm btn-info peserta" title="Peserta" data-id="'.$a->uuid.'"><i class="fa fa-user"></i> Peserta</button> <button class="btn btn-sm btn-success syllabus" title="Content" data-id="'.$a->uuid.'"><i class="fas fa-book"></i> Content</button> <button class="btn btn-sm btn-primary edit" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';
                switch ($a->status) {
                	case 0:
                		$a->status = '<span class="label label-lg label-light-danger label-inline">TIDAK</span>';
                		break;

                	case 1:
                		$a->status = '<span class="label label-lg label-light-success label-inline">AKTIF</span>';
                		break;

                	case 2:
                		$a->status = '<span class="label label-lg label-light-success label-inline">-</span>';
                		break;
                }

                switch ($a->lang) {
                    case 'id':
                        $a->lang = '<img src="/assets/media/svg/flags/004-indonesia.svg" class="img-responsive img-thumbnail" style="height: 40px; width: 60px; object-fit: cover;"/>';
                        break;

                    case 'en':
                        $a->lang = '<img src="/assets/media/svg/flags/226-united-states.svg" class="img-responsive img-thumbnail" style="height: 40px; width: 60px; object-fit: cover;"/>';
                        break;
                }
                return $a;
            });

            return response()->json($course);

        }else{
            abort(404);
        }
    }

    public function show(Request $request)
    {
        $lang = [];
        if(isset($request->hl)) {
            $lang = ['lang' => $request->hl];
        }
        $course = Course::with('Category.Category')->where($lang)->where(function($q) use ($request) {
            if(isset($request->q)) {
                $q->where('nm_course', 'LIKE', '%'.$request->q.'%');
            }
        })->active()->orderBy('id', 'ASC')->get()->makeHidden(['created_at', 'updated_at']);
        if($request->page) {
            $take = 16;
            if($request->take) {
                $take = $request->take;
            }
            $page = $request->page-1;
        	$course = Course::with('Category.Category')->where($lang)->where(function($q) use ($request) {
                if(isset($request->q)) {
                    $q->where('nm_course', 'LIKE', '%'.$request->q.'%');
                }
            })->active()->orderBy('id', 'ASC')->skip($take*$page)->take($take)->get()->makeHidden(['created_at', 'updated_at']);
        }

        $course->map(function($a) {
            $category = [];
            foreach ($a->Category as $value) {
                $category[] = $value->Category->makeHidden(['created_at', 'updated_at']);
            }
            unset($a->Category);
            $a->category = $category;
        });


    	return RestApi::success($course);
    }

    public function joined(Request $request)
    {
        $section = \App\Models\CourseSection::with('CourseOther', 'Course.Category.Category')->where('user_id', JWTAuth::user()->id)->where('is_remidi', '0')->orderBy('id', 'DESC')->get()->makeHidden(['created_at', 'updated_at']);


        if($request->page) {
            $take = 16;
            if($request->take) {
                $take = $request->take;
            }
            $page = $request->page-1;
            $section = \App\Models\CourseSection::with('CourseOther', 'Course.Category.Category')->where('user_id', JWTAuth::user()->id)->where('is_remidi', '0')->orderBy('id', 'DESC')->skip($take*$page)->take($take)->get()->makeHidden(['created_at', 'updated_at']);
        }

        $course = [];

        foreach ($section as $key => $value) {
            if(isset($value->Course->id)) {
                $totalSection = \App\Models\CourseContent::where('course_id', $value->course_id)->count();

                if($totalSection == 0) {
                    $totalSection = 0;
                }else if($totalSection == 1) {
                    $totalSection = 1;
                }else{
                    $totalSection = $totalSection-1;
                }
                $value->Course->section_now = $value->section;
                $value->Course->total_section = $totalSection;
                $value->Course->is_finish = $value->is_finish;
                $value->Course->is_finish_boolean = (($value->is_finish == 'Y') ? true : false);
                $value->Course->is_course_other = false;
                $course[] = $value->Course;
            }else{
                $value->CourseOther->is_finish = $value->is_finish;
                $value->CourseOther->is_finish_boolean = (($value->is_finish == 'Y') ? true : false);
                $value->CourseOther->is_course_other = true;
                $course[] = $value->CourseOther->makeHidden(['username', 'password', 'meeting_url', 'place']);
            }
        }
        $course = collect($course);
        $course->map(function($a) {
            $category = [];
            foreach ($a->Category as $value) {
                $category[] = $value->Category->makeHidden(['created_at', 'updated_at']);
            }
            unset($a->Category);
            $a->category = $category;
        });


        return RestApi::success($course);
    }

    public function detail(Request $request)
    {
        $rules = [
            'course' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = Course::with(['Content' => function($q) {
            $q->orderBy('no_urut', 'ASC');
        }])->where('uuid', $request->course)->first();

        if (!isset($course->id)) {
            return RestApi::error('Kursus tidak ditemukan.', 404);
        }

        $syllabus = [];
        foreach ($course->Content as $value) {
            $syllabus[] = $value->title;
        }
        $course->total_section = $course->Content()->count();
        $course->syllabus = $syllabus;
        unset($course->Content);

        $category = [];
        foreach ($course->Category as $value) {
            $category[] = $value->Category->makeHidden(['created_at', 'updated_at']);
        }
        unset($course->Category);
        $course->category = $category;

        $section = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id,'course_id' => $course->id])->orderBy('id', 'ASC')->first();
        $course->is_joined = false;
        $course->section = null;
        if (isset($section->id)) {
            $course->is_joined = true;
            $course->section = $section->makeHidden(['user_id', 'course_id', 'created_at', 'updated_at']);
            
            $cekSection = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id,'course_id' => $course->id, 'is_remidi' => '1', 'is_finish' => 'Y'])->first();
            if (isset($cekSection->id)) {
                $course->finish_remidi = true;
            }else{
                $course->finish_remidi = false;
            }
        }

        return RestApi::success($course);
    }

    public function join(Request $request)
    {
        $rules = [
            'course' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = Course::with('Content')->where('uuid', $request->course)->first();

        if (!isset($course->id)) {
            return RestApi::error('Kursus tidak ditemukan.', 404);
        }

        if ($course->status == '0') {
            return RestApi::error('Kursus tidak aktif.', 400);
        }

        $section = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id,'course_id' => $course->id])->first();
        if (isset($section->id)) {
            return RestApi::error('Kursus sudah ada.', 400);
        }
        $section = \App\Models\CourseSection::create(['user_id' => JWTAuth::user()->id, 'course_id' => $course->id, 'section' => '0']);

        $totalSection = \App\Models\CourseContent::where('course_id', $course->id)->count();
        return RestApi::success(null, 200, 'Berhasil join kursus.');
    }

    public function section(Request $request)
    {
        $rules = [
            'course' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = Course::with('Content')->where('uuid', $request->course)->first();

        if (!isset($course->id)) {
            return RestApi::error('Kursus tidak ditemukan.', 404);
        }

        if ($course->status == '0') {
            return RestApi::error('Kursus tidak aktif.', 400);
        }

        $section = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id,'course_id' => $course->id])->orderBy('id', 'DESC')->first();
        
        if (!isset($section->id)) {
            return RestApi::error('Anda belum bergabung.', 400);
        }
        $totalSection = \App\Models\CourseContent::where('course_id', $course->id)->count();

        if($totalSection == 0) {
            $totalSection = 0;
        }else if($totalSection == 1) {
            $totalSection = 1;
        }else{
            $totalSection = $totalSection-1;
        }

        return RestApi::success(['total_section' => $totalSection, 'section_now' => $section->section]);
    }

    public function complete(Request $request)
    {
        $rules = [
            'course' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = Course::with('Content.CourseQuestion')->where('uuid', $request->course)->first();


        if (!isset($course->id)) {
            return RestApi::error('Kursus tidak ditemukan.', 404);
        }

        if ($course->status == '0') {
            return RestApi::error('Kursus tidak aktif.', 400);
        }

        $section = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id,'course_id' => $course->id])->orderBy('id', 'DESC')->first();
        if (!isset($section->id)) {
            return RestApi::error('Anda belum bergabung pada kursus ini.', 404);
        }
        
        $courseContentIds = $course->Content->pluck('id')->toArray();
        $totalSoal = \App\Models\CourseQuestion::whereIn('course_content_id', $courseContentIds)->get()->count();
        if($totalSoal == 0) {
            $data = [
                "correct" => 0,
                "wrong" => 0,
                "score" => 100,
                "total_question" => 0,
                "answer_key" => [],
                "is_remidi" => false
            ];
            $section->nilai = 100;
        }else{
            $questionAnswer = \App\Models\QuestionAnswer::with('CourseQuestion')->where('user_id', JWTAuth::user()->id)->whereIn('course_content_id', $courseContentIds)->get();
            $questionKey = [];
            $nilai = 0;
            $benar = 0;
            foreach ($questionAnswer as $value) {
                $value->CourseQuestion->your_answer = $value->answer;
                $questionKey[] = $value->CourseQuestion;
                if($value->answer == $value->CourseQuestion->answer) {
                    $benar++;
                } 
            }
            $nilai = round(($benar/$totalSoal)*100);
            // $nilai = 100;

            $data = [
                "correct" => $benar,
                "wrong" => $totalSoal-$benar,
                "score" => $nilai,
                "total_question" => $totalSoal,
                "answer_key" => $questionKey,
                "is_remidi" => (($nilai < 75) ? true : false)
            ];
            $section->nilai = $nilai;

            if($nilai >= 75 && $section->is_remidi == '1') {
                $section->nilai = 75;
            }

            if($nilai < 75 && $section->is_remidi == '0') {
                \App\Models\CourseSection::create(['user_id' => JWTAuth::user()->id, 'course_id' => $course->id, 'section' => '0', 'is_remidi' => '1']);
            }

            if ($nilai < 75) {
                $section->is_remidi = 1;
            }
        }
        // return RestApi::error($data, 400);

        $section->is_finish = 'Y';
        $section->finished_at = date("Y-m-d H:i:s");

        if($section->update()) {
            return RestApi::success($data, 200, 'Berhasil menyelesaikan kursus.');
        }else{
            return RestApi::error('Sesuatu error terjadi.', 500);
        }
    }

    public function getScore(Request $request)
    {
        $course = Course::with('Content.CourseQuestion')->where('uuid', $request->course)->first();


        if (!isset($course->id)) {
            return RestApi::error('Kursus tidak ditemukan.', 404);
        }

        if ($course->status == '0') {
            return RestApi::error('Kursus tidak aktif.', 400);
        }

        $section = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id, 'course_id' => $course->id, 'is_finish' => 'Y', 'is_remidi' => '0'])->orderBy('id', 'DESC')->first();
        if(!isset($section->id)) {
            return RestApi::error('Anda belum bergabung pada kursus ini.', 400);
        }

        $getRemidi = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id, 'course_id' => $course->id, 'is_finish' => 'Y', 'is_remidi' => '1'])->orderBy('id', 'DESC')->first();
        if (isset($getRemidi->id)) {
            if($getRemidi->nilai >= 75) {
                $nilai = 75;
            }else{
                $getNotRemidi = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id, 'course_id' => $course->id, 'is_finish' => 'Y', 'is_remidi' => '0'])->orderBy('id', 'DESC')->first();
                if($getRemidi->nilai > $getNotRemidi->nilai) {
                    $nilai = $getRemidi->nilai;
                }else{
                    $nilai = $getNotRemidi->nilai;
                }
            }
        }else{
            $getNotRemidi = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id, 'course_id' => $course->id, 'is_finish' => 'Y', 'is_remidi' => '0'])->orderBy('id', 'DESC')->first();
            $nilai = $getNotRemidi->nilai;
        }


        $data = [
            'score' => $nilai
        ];

        // $courseContentIds = $course->Content->pluck('id')->toArray();
        // $totalSoal = \App\Models\CourseQuestion::whereIn('course_content_id', $courseContentIds)->get()->count();
        // if($totalSoal == 0) {
        //     $data = [
        //         "correct" => 0,
        //         "wrong" => 0,
        //         "score" => 100,
        //         "total_question" => 0,
        //         "answer_key" => [],
        //     ];
        // }else{
        //     $questionAnswer = \App\Models\QuestionAnswer::with('CourseQuestion')->where('user_id', JWTAuth::user()->id)->whereIn('course_content_id', $courseContentIds)->get();
        //     $questionKey = [];
        //     $nilai = 0;
        //     $benar = 0;
        //     foreach ($questionAnswer as $value) {
        //         $value->CourseQuestion->your_answer = $value->answer;
        //         $questionKey[] = $value->CourseQuestion;
        //         if($value->answer == $value->CourseQuestion->answer) {
        //             $benar++;
        //         } 
        //     }
        //     $nilai = round(($benar/$totalSoal)*100);
        //     // $nilai = 100;

        //     $data = [
        //         "correct" => $benar,
        //         "wrong" => $totalSoal-$benar,
        //         "score" => $nilai,
        //         "total_question" => $totalSoal,
        //         "answer_key" => $questionKey,
        //     ];
        // }

        return RestApi::success($data, 200);
    }

    public function create(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'nm_course' => 'required|string',
                'overview' => 'required|string',
                'module' => 'required',
                'image' => 'required',
                'lang' => 'required',
                'is_notif' => 'nullable',
                'cat'
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $data = [
                'nm_course' => $request->nm_course,
                'overview' => $request->overview,
                'user_id' => JWTAuth::user()->id,
                'lang' => $request->lang,
            ];

            if(isset($request->status) && $request->status === 'on') {
                $data['status'] = '1';
            }else{
                $data['status'] = '0';
            }

            if(is_uploaded_file($request->image)) {
                $rules = [
                    'image' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'COURSE_IMAGE_'.strtoupper(str_slug($request->nm_course, "_")).'_'.time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('uploads/images'), $images);
                // unset($request['image']);
                $data['image'] = $images;
            }else if(filter_var($request->image, FILTER_VALIDATE_URL)){
                $data['image'] = $request->image;
            }

            if(is_uploaded_file($request->module)) {
                $rules = [
                    'module' => 'required|mimes:pdf|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $modules = 'COURSE_MODULE_'.strtoupper(str_slug($request->nm_course, "_")).'_'.time().'.'.request()->module->getClientOriginalExtension();
                request()->module->move(public_path('uploads/modules'), $modules);
                // unset($request['module']);
                $data['module'] = $modules;
            }else if(filter_var($request->module, FILTER_VALIDATE_URL)){
                $data['module'] = $request->module;
            }


            $course = Course::create($data);

            if (isset($request->categories)) {
                foreach (explode(',', $request->categories) as $res) {
                    \App\Models\CourseCategory::create(['course_id' => $course->id, 'category_id' => $res]);
                }
            }

            if($course) {
                if ($request->is_notif) {
                    $notif = Notification::create([
                        'judul' => 'Kursus baru: ' . $course->nm_course,
                        'isi' => $course->overview,
                        'image' => $course->image,
                        'onclick' => 'SHOW_COURSE',
                        'target' => $course->uuid,
                    ]);

                    if ($notif) {
                        $topic = Topic::where('slug', 'all')->first();
                        $notifTopic = NotificationTopic::create([
                            'notification_id' => $notif->id,
                            'topic_id' => $topic->id
                        ]);

                        if ($notifTopic) {
                            AppHelper::sendNotif($notif, $topic);
                        }
                    }
                }
                return RestApi::success('Berhasil menambah data.');
            } else {
                return RestApi::error('Gagal menambah data.', 400);
            }
            
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }

    public function edit($uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {
            
            $course = Course::findByUuid($uuid);

            if (!isset($course->id)) {
                return RestApi::error('Kursus tidak ditemukan.', 404);
            }

            $categories = [];

            $categoriesx = \App\Models\CourseCategory::where('course_id', $course->id)->get();
            foreach ($categoriesx as $res) {
                $categories[] = $res->category_id;
            }

            $course->categories = $categories;

            return response()->json([
                'status' => true,
                'data' => $course
            ]);
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }

    public function update(Request $request, $uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {

            $rules = [
                'nm_course' => 'required|string',
                'overview' => 'required|string',
                'user_id' => 'required',
                'lang' => 'required|string',
            ];


            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }
            
            $data = [
                'nm_course' => $request->nm_course,
                'overview' => $request->overview,
                'user_id' => $request->user_id,
                'lang' => $request->lang,
            ];

            if(isset($request->status) && $request->status === 'on') {
                $data['status'] = '1';
            }else{
                $data['status'] = '0';
            }

            $course = Course::findByUuid($uuid);

            if (!isset($course->id)) {
                return RestApi::error('Kursus tidak ditemukan.', 404);
            }

            if(is_uploaded_file($request->image)) {
                $rules = [
                    'image' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'COURSE_IMAGE_'.strtoupper(str_slug($request->nm_course, "_")).'_'.time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('uploads/images'), $images);
                // unset($request['image']);
                $data['image'] = $images;
            }else if(filter_var($request->image, FILTER_VALIDATE_URL) && strpos($request->image, url('/')) === false){
                $data['image'] = $request->image;
            }

            if(is_uploaded_file($request->module)) {
                $rules = [
                    'module' => 'required|mimes:pdf|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $modules = 'COURSE_MODULE_'.strtoupper(str_slug($request->nm_course, "_")).'_'.time().'.'.request()->module->getClientOriginalExtension();
                request()->module->move(public_path('uploads/modules'), $modules);
                // unset($request['module']);
                $data['module'] = $modules;
            }else if(filter_var($request->module, FILTER_VALIDATE_URL) && strpos($request->module, url('/')) === false){
                $data['module'] = $request->module;
            }

            $cek = \App\Models\CourseCategory::where('course_id', $course->id)->delete();
            if(isset($request->categories)) {
                foreach (explode(',', $request->categories) as $res) {
                    if(isset($res)) {
                        \App\Models\CourseCategory::create(['course_id' => $course->id, 'category_id' => $res]);
                    }
                }
            }

            if ($course->update($data)) {
                return RestApi::success('Berhasil mengubah data.');
            } else {
                return RestApi::error('Gagal mengubah data.', 400);
            }
            
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
    
    public function delete($uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {
            
            $course = Course::findByUuid($uuid);

            if (!isset($course->id)) {
                return RestApi::error('Kursus tidak ditemukan.', 404);
            }

            if(isset($course->image)){
                $img = public_path('uploads/images/').$course->image;
                if (file_exists($img) && is_file($img)) {
                    unlink($img);
                }
            }

            if(isset($course->module)){
                $mod = public_path('uploads/modules/').$course->module;
                if (file_exists($mod) && is_file($mod)) {
                    unlink($mod);
                }
            }
            
            $courseUuid = $course->uuid;
            if ($course->delete()) {
                Notification::where('target', $courseUuid)->delete();
                return RestApi::success('Berhasil menghapus data.');
            } else {
                return RestApi::error('Gagal menghapus data.', 400);
            }
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }

    public function peserta(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);

            $cek = Course::findByUuid($request->course);

            if(!isset($cek->id)) {
                return RestApi::error('404 Not Found!', 404);
            }
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $course = \App\Models\CourseSection::with('User', 'Course')->where('course_id', $cek->id)->whereHas('User', function($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                ->orWhere('nik', 'LIKE', '%'.$request->search.'%')
                ->orWhere('jenis', 'LIKE', '%'.$request->search.'%')
                ->orWhere('jabatan', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $course->map(function($a) {
                // $a->description = AppHelper::readMore(strip_tags($a->description), 60);
                // $a->image = '<img src="'.$a->image_url.'" class="img-responsive" style="height: 40px; width: 60px; object-fit: cover;"/>';
                // $a->action = '<button class="btn btn-sm btn-primary konfirm" title="Konfirmasi" data-id="'.$a->uuid.'"><i class="la la-check"></i> VERIFIKASI</button> <button class="btn btn-sm btn-danger reject" title="Kuota Habis" data-id="'.$a->uuid.'"><i class="la la-close"></i> Kuota Habis</button>';

                switch ($a->status) {
                    case 0:
                        $a->status = '<span class="label label-lg label-light-warning label-inline">BELUM</span>';
                        break;

                    case 1:
                        $a->status = '<span class="label label-lg label-light-success label-inline">TERVERIFIKASI</span>';
                        break;

                    default:
                        $a->status = '<span class="label label-lg label-light-danger label-inline">KUOTA HABIS</span>';
                        break;
                }
            });

            return response()->json($course);

        }else{
            abort(404);
        }
    }
}
