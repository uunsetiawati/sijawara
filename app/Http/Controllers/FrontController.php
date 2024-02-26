<?php

namespace App\Http\Controllers;

use Validator, DB, RestApi;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseOther;

class FrontController extends Controller
{
    public function courseDetail(Request $request)
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

        return RestApi::success($course);
    }

    public function courseOtherDetail(Request $request)
    {
        $rules = [
            'course' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = CourseOther::where('uuid', $request->course)->first();

        if (!isset($course->id)) {
            return RestApi::error('Kursus tidak ditemukan.', 404);
        }

        $category = [];
        foreach ($course->Category as $value) {
            $category[] = $value->Category->makeHidden(['created_at', 'updated_at']);
        }
        unset($course->Category);
        $course->category = $category;
        $course->makeHidden(['username', 'password', 'meeting_url', 'place']);
        
        if(strtotime($course->date_start) <= strtotime(date('Y-m-d')) && strtotime($course->date_end) >= strtotime(date('Y-m-d'))) {
            $course->sudah_terlaksana = 'N';
        }else if(strtotime($course->date_end) <= strtotime(date('Y-m-d'))) {
            $course->sudah_terlaksana = 'Y';
        }else{
            $course->sudah_terlaksana = 'N';                
        }

        return RestApi::success($course);
    }

    public function courseEvents(Request $request)
    {
        $typeID = [
            'pelatihan'     => '3',
            'ukm'           => '2',
            'koperasi'      => '1',
            'konsultasi'    => '4',
            'bimbingan'     => '5',
            'kursil'        => '6',
            'seminar'       => '7',
            'pendampingan'  => '8'
        ];

        $whereOnline = [];
        $whereTahun = null;
        if(isset($request->type)) {
            foreach (explode(',', $request->type) as $key => $value) {
                if($key == 0) {
                    if($value == 'online') {
                        $whereOnline = ['is_online' => '1'];
                    } else if ($value == 'offline') {
                        $whereOnline = ['is_online' => '0'];
                    }
                }
            }
            if(substr(explode(',', $request->type)[count(explode(',', $request->type))-1], 0, 2) == '20') {
                $whereTahun = explode(',', $request->type)[count(explode(',', $request->type))-1];
            }
        }

        // $test = [];
        // foreach (explode(',', $request->type) as $key => $value) {
        //     if($key != 0 && substr($value, 0, 2) != '20') {
        //         $test[] = $typeID[$value];
        //     }
        // }

        // dd($test);
        
        $course = CourseOther::with('Category.Category')->where('title', 'LIKE', '%'.$request->q.'%')->where($whereOnline)->whereHas('Category', function($q) use ($request, $typeID){
            $whereQ = [];
            foreach (explode(',', $request->type) as $key => $value) {
                if($key != 0 && substr($value, 0, 2) != '20') {
                    $whereQ[] = $typeID[$value];
                }
            }
            if($whereQ != []) {
                $q->whereIn('category_id', $whereQ);
            }
        });
        if($whereTahun != null) {
            $course = $course->whereYear('date_start', $whereTahun);
        }
        $course = $course->active()->orderBy('date_end', 'DESC')->get()->makeHidden(['created_at', 'updated_at', 'username', 'password', 'meeting_url', 'place', 'description']);
        if($request->page) {
            $take = 16;
            if($request->take) {
                $take = $request->take;
            }
            $page = $request->page-1;
            $course = CourseOther::with('Category.Category')->where('title', 'LIKE', '%'.$request->q.'%')->where($whereOnline)->whereHas('Category', function($q) use ($request, $typeID){
                $whereQ = [];
                foreach (explode(',', $request->type) as $key => $value) {
                    if($key != 0 && substr($value, 0, 2) != '20') {
                        $whereQ[] = $typeID[$value];
                    }
                }
                if($whereQ != []) {
                    $q->whereIn('category_id', $whereQ);
                }
            });
            if($whereTahun != null) {
                $course = $course->whereYear('date_start', $whereTahun);
            }
            $course = $course->active()->orderBy('date_end', 'DESC')->skip($take*$page)->take($take)->get()->makeHidden(['created_at', 'updated_at', 'username', 'password', 'meeting_url', 'place', 'description']);
        }

        $course->map(function($a) {
            $category = [];
            foreach ($a->Category as $value) {
                $category[] = $value->Category->makeHidden(['created_at', 'updated_at']);
            }
            unset($a->Category);
            $a->category = $category;

            if(strtotime($a->date_start) <= strtotime(date('Y-m-d')) && strtotime($a->date_end) >= strtotime(date('Y-m-d'))) {
                $a->sudah_terlaksana = 'X';
            }else if(strtotime($a->date_end) <= strtotime(date('Y-m-d'))) {
                $a->sudah_terlaksana = 'Y';
            }else{
                $a->sudah_terlaksana = 'N';
            }
        });


        return RestApi::success($course);
    }
}
