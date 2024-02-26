<?php

namespace App\Http\Controllers;

use DB, Validator, AppHelper, RestApi, JWTAuth;
use Illuminate\Http\Request;
use App\Models\CourseContent;
use App\Models\QuestionAnswer;

class CourseContentController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);

            $course = \App\Models\Course::findByUuid($request->course);

            if(!isset($course->id)) {
                return RestApi::error('Kursus tidak ditemukan.', 404);
            }
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $course = CourseContent::where('course_id', $course->id)->where(function($q) use ($request) {
                $q->where('title', 'LIKE', '%'.$request->search.'%')
                ->orWhere('content', 'LIKE', '%'.$request->search.'%');
            })->orderBy('no_urut','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $course->map(function($a) {
                $a->content = AppHelper::readMore(strip_tags($a->content), 60);
                $a->action = '<button class="btn btn-sm btn-primary edit" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';
                return $a;
            });

            return response()->json($course);

        }else{
            abort(404);
        }
    }

    public function create(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'course_id' => 'required',
                'no_urut' => 'required',
                'title' => 'required',
                'content' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $data = [
                'course_id' => $request->course_id,
                'no_urut' => $request->no_urut,
                'title' => $request->title,
                'content' => $request->content,
            ];

            if(is_uploaded_file($request->module)) {
                $rules = [
                    'module' => 'required|mimes:pdf|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $modules = 'COURSE_CONTENT_MODULE_'.strtoupper(str_slug($request->nm_course, "_")).'_'.time().'.'.request()->module->getClientOriginalExtension();
                request()->module->move(public_path('uploads/modules'), $modules);
                // unset($request['module']);
                $data['module'] = $modules;
            }else if(filter_var($request->module, FILTER_VALIDATE_URL)){
                $data['module'] = $request->module;
            }

            $courseContent = CourseContent::create($data);

            if($courseContent) {
                if($request->course_question) {
                    foreach (json_decode($request->course_question) as $key => $result) {
                        $question = \App\Models\CourseQuestion::create(['course_content_id' => $courseContent->id, 'question' => $result->question, 'a_answer' => $result->a_answer, 'b_answer' => $result->b_answer, 'c_answer' => $result->c_answer, 'd_answer' => $result->d_answer, 'answer' => $result->answer, 'description' => $result->description]);
                    }
                }
                // if($request->question) {
                //     $question = \App\Models\CourseQuestion::create(['course_content_id' => $courseContent->id, 'question' => $request->question, 'a_answer' => $request->a_answer, 'b_answer' => $request->b_answer, 'c_answer' => $request->c_answer, 'd_answer' => $request->d_answer, 'answer' => $request->answer, 'description' => $request->description]);
                // }

                return RestApi::success('Berhasil menambah data.', 200);
            }
            
        }else{
            return RestApi::error('404 Not Found.', 404);
        }// preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
    }

    public function edit(Request $request, $uuid)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $courseContent = CourseContent::with('CourseQuestion')->where('uuid', $uuid)->first();

            if(!isset($courseContent->id)) {
                return RestApi::error('Konten tidak ditemukan.', 404);
            }

            if(isset($courseContent->CourseQuestion->question)) {
                $courseContent->question = $courseContent->CourseQuestion->question;
                $courseContent->a_answer = $courseContent->CourseQuestion->a_answer;
                $courseContent->b_answer = $courseContent->CourseQuestion->b_answer;
                $courseContent->c_answer = $courseContent->CourseQuestion->c_answer;
                $courseContent->d_answer = $courseContent->CourseQuestion->d_answer;
                $courseContent->answer = $courseContent->CourseQuestion->answer;
                $courseContent->description = $courseContent->CourseQuestion->description;
            }else{
                $courseContent->question = null;
                $courseContent->a_answer = null;
                $courseContent->b_answer = null;
                $courseContent->c_answer = null;
                $courseContent->d_answer = null;
                $courseContent->answer = null;
                $courseContent->description = null;
            }
            
            return response()->json([
                'status' => true,
                'data' => $courseContent
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => '404 Not Found.'
            ], 404);
        }
    }

    public function update(Request $request, $uuid)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'course_id' => 'required',
                'no_urut' => 'required',
                'title' => 'required',
                'content' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $courseContent = CourseContent::with('CourseQuestion')->where('uuid', $uuid)->first();

            if(!isset($courseContent->id)) {
                return RestApi::error('Konten tidak ditemukan.', 404);
            }

            $data = [
                'course_id' => $request->course_id,
                'no_urut' => $request->no_urut,
                'title' => $request->title,
                'content' => $request->content,
            ];

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
            if($courseContent->update($data)){
                if($request->course_question) {
                    if(isset($courseContent->CourseQuestion[0]->id)){
                        $courseContent->CourseQuestion->each->delete();
                    }
                    foreach (json_decode($request->course_question) as $key => $result) {
                        $question = \App\Models\CourseQuestion::create(['course_content_id' => $courseContent->id, 'question' => $result->question, 'a_answer' => $result->a_answer, 'b_answer' => $result->b_answer, 'c_answer' => $result->c_answer, 'd_answer' => $result->d_answer, 'answer' => $result->answer, 'description' => $result->description]);
                    }
                }
                return RestApi::success('Berhasil mengubah data.');
            }
        }else{
            return response()->json([
                'status' => false,
                'message' => '404 Not Found.'
            ], 404);
        }
    }

    public function delete($uuid)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $courseContent = CourseContent::findByUuid($uuid);

            if(!isset($courseContent->id)) {
                return RestApi::error('Konten tidak ditemukan.', 404);
            }

            if($courseContent->delete()) {
                return RestApi::success('Berhasil menghapus data.');
            }else{
                return RestApi::error('Gagal menghapus data.');
            }
            
        }else{
            return response()->json([
                'status' => false,
                'message' => '404 Not Found.'
            ], 404);
        }
    }

    public function detail(Request $request)
    {
    	$rules = [
            'section' => 'required',
            'course' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = \App\Models\Course::findByUuid($request->course);

        if (!isset($course->id)) {
        	return RestApi::error('Kursus tidak ditemukan.', 404);
        }

    	$courseContent = CourseContent::with('CourseQuestion')->where(['course_id' => $course->id])->orderBy('no_urut', 'ASC')->get();

    	if (!isset($courseContent[$request->section])) {
    		return RestApi::error('Content tidak ditemukan.', 404);
    	}

        $section = \App\Models\CourseSection::where(['course_id' => $course->id, 'user_id' => JWTAuth::user()->id])->orderBy('id', 'DESC')->first();

        if (!isset($section->id)) {
            return RestApi::error('Anda belum bergabung kedalan kursus.', 500);
        }

        if ($section->section == ($request->section-1) && count($courseContent) >= $request->section) {
            $section->update(['section' => $request->section]);
        }else if(($section->section+1) <= ($request->section-1)){
            return RestApi::error('Selesaikan dulu syllabus sebelumnya.', 500);
        }

        if (isset($courseContent[$request->section]->CourseQuestion)) {
            $courseContent[$request->section]->CourseQuestion->makeHidden(['answer', 'description', 'created_at', 'updated_at']);
        }

        $courseContent[$request->section]->CourseQuestion->map(function($a) {
            $cek = \App\Models\QuestionAnswer::where(['user_id' => JWTAuth::user()->id, 'course_question_id' => $a->id])->first();
            
            if(!isset($cek->id)) {
                $a->your_answer = null;
            }else{
                $a->your_answer = $cek->answer;
            }
        });
    	return RestApi::success($courseContent[$request->section], 200, 'Berhasil membuka section.');
    }

    public function checkQuestion(Request $request)
    {
        $rules = [
            'uuid' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $json = [];
        foreach ($request->uuid as $key => $value) {
            $question = \App\Models\CourseQuestion::findByUuid($key);

            // if(!isset($question->id)) {
            //     return RestApi::error('Soal tidak ditemukan.');
            // }

            $cek = \App\Models\QuestionAnswer::where(['user_id' => JWTAuth::user()->id, 'course_question_id' => $question->id])->first();
            
            if(!isset($cek->id)) {
                $json[] = ['uuid' => $key, 'answer' => null];
                // return RestApi::error('Anda belum mengisi jawaban.', 400, null);
            }else{
                $json[] = ['uuid' => $key, 'answer' => $cek->answer];
            }
        }


        return RestApi::success($json);
    }

    public function saveAnswer(Request $request)
    {
        $rules = [
            'uuid' => 'required',
            'answer' => 'required|in:a,b,c,d',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $question = \App\Models\CourseQuestion::findByUuid($request->uuid);

        if(!isset($question->id)) {
            return RestApi::error('Soal tidak ditemukan.');
        }

        $cek = \App\Models\QuestionAnswer::where(['user_id' => JWTAuth::user()->id, 'course_content_id' => $question->course_content_id, 'course_question_id' => $question->id])->first();

        if(!isset($cek->id)) {
            $save = \App\Models\QuestionAnswer::create(['user_id' => JWTAuth::user()->id, 'course_content_id' => $question->course_content_id, 'course_question_id' => $question->id, 'answer' => $request->answer]);
            if($save) {
                return RestApi::success('Berhasil menyimpan jawaban.');
            }else{
                return RestApi::error('Sesuatu error terjadi.', 400);
            }
        }else{
            $cek->answer = $request->answer;
            if($cek->update()) {
                return RestApi::success('Berhasil menyimpan jawaban.');
            }else{
                return RestApi::error('Sesuatu error terjadi.', 400);
            }
        }
    }
}
