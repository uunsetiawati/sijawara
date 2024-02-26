<?php

namespace App\Http\Controllers;

use DB, Validator, AppHelper, RestApi;
use Illuminate\Http\Request;
use App\Models\Widyaiswara;

class WidyaiswaraController extends Controller
{
    public function index(Request $request)
    {
    	if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $widyaiswara = Widyaiswara::where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                ->orWhere('position', 'LIKE', '%'.$request->search.'%')
                ->orWhere('about', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $widyaiswara->map(function($a) {
            	$a->image = '<img src="'.$a->photo_url.'" class="img-responsive" style="width: 40px;"/>';
                $a->action = '<button class="btn btn-sm btn-primary edit" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';
                return $a;
            });

            return response()->json($widyaiswara);

        }else{
            abort(404);
        }
    }

    public function show()
    {
    	$widyaiswara = Widyaiswara::orderBy('id', 'ASC')->get()->makeHidden(['created_at', 'updated_at', 'uuid']);;
    	return RestApi::success($widyaiswara);
    }

    public function create(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'name' => 'required|string',
                'position' => 'required|string',
                'about' => 'string',
                'image' => 'required',
                'detail_image' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $data = [
                'name' => $request->name,
                'position' => $request->position,
                'about' => $request->about,
            ];

            if(is_uploaded_file($request->image)) {
                $rules = [
                    'image' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'WIDYAISWARA_IMAGE_'.strtoupper(str_slug($request->name, "_")).'_'.time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('uploads/widyaiswaras'), $images);
                // unset($request['image']);
                $data['photo'] = $images;
            }

            if(is_uploaded_file($request->detail_image)) {
                $rules = [
                    'detail_image' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'WIDYAISWARA_IMAGE_POPUP_'.strtoupper(str_slug($request->name, "_")).'_'.time().'.'.request()->detail_image->getClientOriginalExtension();
                request()->detail_image->move(public_path('uploads/widyaiswaras'), $images);
                // unset($request['detail_image']);
                $data['popup'] = $images;
            }

            $widyaiswara = Widyaiswara::create($data);

            if($widyaiswara) {
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
            
            $widyaiswara = Widyaiswara::findByUuid($uuid);

            if (!isset($widyaiswara->id)) {
                return RestApi::error('Widyaiswara tidak ditemukan.', 404);
            }
            
            return response()->json([
                'status' => true,
                'data' => $widyaiswara
            ]);
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }

    public function update(Request $request, $uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {

            $rules = [
                'name' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }
            
            $widyaiswara = Widyaiswara::findByUuid($uuid);

            if (!isset($widyaiswara->id)) {
                return RestApi::error('Widyaiswara tidak ditemukan.', 404);
            }

            $data = [
                'name' => $request->name,
                'position' => $request->position,
                'about' => $request->about,
            ];

            if(is_uploaded_file($request->image)) {
                $rules = [
                    'image' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'WIDYAISWARA_IMAGE_'.strtoupper(str_slug($request->name, "_")).'_'.time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('uploads/widyaiswaras'), $images);
                // unset($request['image']);
                $data['photo'] = $images;

                if(isset($widyaiswara->photo)){
                    $img = public_path('uploads/widyaiswaras/').$widyaiswara->photo;
                    if (file_exists($img) && is_file($img)) {
                        unlink($img);
                    }
                }
            }

            if(is_uploaded_file($request->detail_image)) {
                $rules = [
                    'detail_image' => 'required|mimes:jpg,png,jpeg|max:5120',
                ];

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'WIDYAISWARA_IMAGE_POPUP_'.strtoupper(str_slug($request->name, "_")).'_'.time().'.'.request()->detail_image->getClientOriginalExtension();
                request()->detail_image->move(public_path('uploads/widyaiswaras'), $images);
                // unset($request['detail_image']);
                $data['popup'] = $images;

                if(isset($widyaiswara->popup)){
                    $img = public_path('uploads/widyaiswaras/').$widyaiswara->popup;
                    if (file_exists($img) && is_file($img)) {
                        unlink($img);
                    }
                }
            }

            if ($widyaiswara->update($data)) {
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
            
            $widyaiswara = Widyaiswara::findByUuid($uuid);

            if (!isset($widyaiswara->id)) {
                return RestApi::error('Widyaiswara tidak ditemukan.', 404);
            }

            if(isset($widyaiswara->photo)){
                $img = public_path('uploads/widyaiswaras/').$widyaiswara->photo;
                if (file_exists($img) && is_file($img)) {
                    unlink($img);
                }
            }

            if(isset($widyaiswara->popup)){
                $img = public_path('uploads/widyaiswaras/').$widyaiswara->popup;
                if (file_exists($img) && is_file($img)) {
                    unlink($img);
                }
            }
            
            if ($widyaiswara->delete()) {
                return RestApi::success('Berhasil menghapus data.');
            } else {
                return RestApi::error('Gagal menghapus data.', 400);
            }
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
}
