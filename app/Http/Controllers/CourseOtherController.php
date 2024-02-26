<?php

namespace App\Http\Controllers;

use JWTAuth, DB, Validator, AppHelper, RestApi;
use Illuminate\Http\Request;
use App\Models\CourseOther;
use App\Models\Notification;
use App\Models\NotificationTopic;
use App\Models\Topic;
use Illuminate\Support\Carbon;

class CourseOtherController extends Controller
{
    public function index(Request $request)
    {
    	if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $course = CourseOther::where(function($q) use ($request) {
                $q->where('title', 'LIKE', '%'.$request->search.'%');
            })->orderBy('date_start','DESC')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $course->map(function($a) {
            	$a->description = AppHelper::readMore(strip_tags($a->description), 60);
            	$a->image = '<img src="'.$a->image_url.'" class="img-responsive" style="height: 40px; width: 60px; object-fit: cover;"/>';
                $a->action = '<button class="btn btn-sm btn-success peserta" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-user"></i> Peserta</button> <button class="btn btn-sm btn-primary edit" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';
                switch ($a->is_active) {
                	case 0:
                		$a->is_active = '<span class="label label-lg label-light-danger label-inline">TIDAK</span>';
                		break;

                	case 1:
                		$a->is_active = '<span class="label label-lg label-light-success label-inline">AKTIF</span>';
                		break;

                	default:
                		$a->is_active = '<span class="label label-lg label-light-success label-inline">-</span>';
                		break;
                }

                switch ($a->is_online) {
                	case 0:
                		$a->is_online = '<span class="label label-lg label-light-info label-inline">OFFLINE</span>';
                		break;

                	case 1:
                		$a->is_online = '<span class="label label-lg label-light-success label-inline">ONLINE</span>';
                		break;

                	default:
                		$a->is_online = '<span class="label label-lg label-light-success label-inline">-</span>';
                		break;
                }
                return $a;
            });

            return response()->json($course);

        }else{
            abort(404);
        }
    }

    public function peserta(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);

            $cek = CourseOther::findByUuid($request->course);

            if(!isset($cek->id)) {
                return RestApi::error('404 Not Found!', 404);
            }
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $course = \App\Models\CourseSection::with('User', 'CourseOther')->where('course_other_id', $cek->id)->whereHas('User', function($q) use ($request) {
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

    public function verif(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'uuid' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $section = \App\Models\CourseSection::findByUuid($request->uuid);

            if(!isset($section->id)) {
                return RestApi::error('User tidak ditemukan.', 404);
            }

            $section->status = '1';

            if($section->update()) {
                return RestApi::success('Berhasil memverifikasi.');
            }else{
                return RestApi::error('Sesuatu error terjadi.', 500);
            }
        }else{
            abort(404);
        }
    }

    public function reject(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'uuid' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $section = \App\Models\CourseSection::findByUuid($request->uuid);

            if(!isset($section->id)) {
                return RestApi::error('User tidak ditemukan.', 404);
            }

            $section->status = '4';

            if($section->update()) {
                return RestApi::success('Berhasil mengubah status [Kuota Penuh].');
            }else{
                return RestApi::error('Sesuatu error terjadi.', 500);
            }
        }else{
            abort(404);
        }
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

        $section = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id,'course_other_id' => $course->id])->first();
        $course->is_joined = false;
        $course->is_confirmed = false;
        if(JWTAuth::user()->level != 'admin') {
            if (isset($section->id)) {
                $course->is_joined = true;
                if ($section->status != '1') {
                    // if($course->is_online == '1') {
                        $course->makeHidden(['username', 'password', 'meeting_url', 'place']);
                    // }
                }else{
                    $course->is_confirmed = true;
                }
                // $course->section = $section->makeHidden(['user_id', 'course_id', 'created_at', 'updated_at']);
            }
        }

        return RestApi::success($course);
    }

    public function show(Request $request)
    {
        $where = [];
        if(isset($request->type)) {
            if($request->type == 'online') {
                $where = ['is_online' => '1'];
            } else if ($request->type == 'offline') {
                $where = ['is_online' => '0'];
            }
        }
        
        $course = CourseOther::with('Category.Category')->where('date_end', '>=', date('Y-m-d'))->where(function($q) use ($request) {
            if(isset($request->q)) {
                $q->where('title', 'LIKE', '%'.$request->q.'%');
            }
        })->where($where)->active()->orderBy('date_start', 'ASC')->get()->makeHidden(['created_at', 'updated_at', 'username', 'password', 'meeting_url', 'place']);
        if($request->page) {
            $take = 16;
            if($request->take) {
                $take = $request->take;
            }
            $page = $request->page-1;
            $course = CourseOther::with('Category.Category')->where('date_end', '>=', date('Y-m-d'))->where(function($q) use ($request) {
                if(isset($request->q)) {
                    $q->where('title', 'LIKE', '%'.$request->q.'%');
                }
            })->where($where)->active()->orderBy('date_start', 'ASC')->skip($take*$page)->take($take)->get()->makeHidden(['created_at', 'updated_at', 'username', 'password', 'meeting_url', 'place']);
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

    public function join(Request $request)
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

        if ($course->is_active == '0') {
            return RestApi::error('Kursus tidak aktif.', 400);
        }
        $checkQuota = \App\Models\CourseSection::where('course_other_id', $course->id)->count();
        if($checkQuota >= $course->quota) {
            return RestApi::error('Maaf, Kuota telah habis.', 400);
        }

        $section = \App\Models\CourseSection::where(['user_id' => JWTAuth::user()->id,'course_other_id' => $course->id])->first();
        if (isset($section->id)) {
            return RestApi::error('Sudah bergabung.', 400);
        }

        // if (Carbon::parse($course->date_end)->isPast()) {
        //     return RestApi::error('Kursus sudah berakhir.', 400);
        // }

        $section = \App\Models\CourseSection::create(['user_id' => JWTAuth::user()->id, 'course_other_id' => $course->id, 'status' => '1']);
        return RestApi::success(null, 200, 'Berhasil bergabung, Silakan tunggu konfirmasi admin.');
    }

    public function create(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required',
                'date_start' => 'required',
                'time_start' => 'required',
                'categories' => 'required',
                'quota' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'date_start' => $request->date_start,
				'time_start' => ((strlen($request->time_start) == 4) ? '0'.$request->time_start : $request->time_start),
                'date_end' => $request->date_end,
				'time_end' => ((strlen($request->time_end) == 4) ? '0'.$request->time_end : $request->time_end),
				'quota' => $request->quota,
            ];

            if(isset($request->is_active) && $request->is_active === 'on') {
                $data['is_active'] = '1';
            }else{
                $data['is_active'] = '0';
            }

            if(isset($request->is_online) && $request->is_online === 'on') {
                $data['is_online'] = '1';
            }else{
                $data['is_online'] = '0';
            }

            if($data['is_online'] == '1') {
            	$rules = [
	                'meeting_url' => 'required',
	            ];

	            $validator = Validator::make($request->all(), $rules);
	            if($validator->fails()) {
	                return RestApi::error($validator->messages()->first(), 400);
	            }

	            $data['meeting_url'] = $request->meeting_url;
	            $data['username'] = $request->username;
	            $data['password'] = $request->password;
            }else{
            	$rules = [
	                'place' => 'required',
	            ];

	            $validator = Validator::make($request->all(), $rules);
	            if($validator->fails()) {
	                return RestApi::error($validator->messages()->first(), 400);
	            }
	            $data['place'] = $request->place;
            }

            if(is_uploaded_file($request->image)) {
                $rules = [
                    'image' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'COURSE_OTHER_IMAGE_'.strtoupper(str_slug($request->title, "_")).'_'.time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('uploads/images'), $images);
                $data['image'] = $images;
            }


            $course = CourseOther::create($data);

            if (isset($request->categories)) {
                foreach (explode(',', $request->categories) as $res) {
                    \App\Models\CourseCategory::create(['course_other_id' => $course->id, 'category_id' => $res]);
                }
            }

            if($course) {
                if ($request->is_notif) {
                    $notif = Notification::create([
                        'judul' => 'Kursus baru: ' . $course->title,
                        'isi' => $course->description,
                        'image' => $course->image,
                        'onclick' => 'SHOW_COURSE_OTHER',
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
            
            $course = CourseOther::findByUuid($uuid);

            if (!isset($course->id)) {
                return RestApi::error('Kursus tidak ditemukan.', 404);
            }

            $categories = [];

            $categoriesx = \App\Models\CourseCategory::where('course_other_id', $course->id)->get();
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
                'title' => 'required',
                'description' => 'required',
                'date_start' => 'required',
                'time_start' => 'required',
                'categories' => 'required',
                'quota' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'date_start' => $request->date_start,
                'time_start' => ((strlen($request->time_start) == 4) ? '0'.$request->time_start : $request->time_start),
                'date_end' => $request->date_end,
                'time_end' => ((strlen($request->time_end) == 4) ? '0'.$request->time_end : $request->time_end),
                'quota' => $request->quota,
            ];

            if(isset($request->is_active) && $request->is_active === 'on') {
                $data['is_active'] = '1';
            }else{
                $data['is_active'] = '0';
            }

            if(isset($request->is_online) && $request->is_online === 'on') {
                $data['is_online'] = '1';
            }else{
                $data['is_online'] = '0';
            }


            if($data['is_online'] == '1') {
                $rules = [
                    'meeting_url' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $data['meeting_url'] = $request->meeting_url;
                $data['username'] = $request->username;
                $data['password'] = $request->password;
                $data['place'] = null;
            }else{
                $rules = [
                    'place' => 'required',
                ];

                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }
                $data['place'] = $request->place;
                $data['meeting_url'] = null;
                $data['username'] = null;
                $data['password'] = null;
            }

            $course = CourseOther::findByUuid($uuid);

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

                if (isset($course->image)) {
                    $img = public_path('uploads/images/').$course->image;
                    if (file_exists($img) && is_file($img)) {
                        unlink($img);
                    }
                }

                $images = 'COURSE_OTHER_IMAGE_'.strtoupper(str_slug($request->title, "_")).'_'.time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('uploads/images'), $images);
                $data['image'] = $images;
            }


            $cek = \App\Models\CourseCategory::where('course_other_id', $course->id)->delete();
            if(isset($request->categories)) {
                foreach (explode(',', $request->categories) as $res) {
                    if(isset($res)) {
                        \App\Models\CourseCategory::create(['course_other_id' => $course->id, 'category_id' => $res]);
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
            
            $course = CourseOther::findByUuid($uuid);

            if (!isset($course->id)) {
                return RestApi::error('Kursus tidak ditemukan.', 404);
            }

            if (isset($course->image)) {
                $img = public_path('uploads/images/').$course->image;
                if (file_exists($img) && is_file($img)) {
                    unlink($img);
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
}
