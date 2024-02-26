<?php

namespace App\Http\Controllers;

use DB, Validator, AppHelper, RestApi;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function show()
    {
    	$slider = Slider::get()->makeHidden(['created_at', 'updated_at', 'uuid']);;
    	return RestApi::success($slider);
    }

    public function index(Request $request)
    {
    	if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $slider = Slider::where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $slider->map(function($a) {
            	$a->image = '<img src="'.$a->image_url.'" class="img-responsive" style="width: 200px;"/>';
                $a->action = '<button class="btn btn-sm btn-primary edit" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';
                return $a;
            });

            return response()->json($slider);

        }else{
            abort(404);
        }
    }

    public function create(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'name' => 'required|string',
                'image' => 'required|mimes:jpg,png,jpeg|max:5120'
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $data = ['name' => $request->name];

            if(is_uploaded_file($request->image)) {
                $images = 'SLIDER_IMAGE_'.strtoupper(str_slug($request->name, "_")).'_'.time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('images/slider'), $images);
                $data['image'] = $images;
            }

            $slider = Slider::create($data);

            if($slider) {
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
            
            $slider = Slider::findByUuid($uuid);

            if (!isset($slider->id)) {
                return RestApi::error('Slider tidak ditemukan.', 404);
            }
            
            return response()->json([
                'status' => true,
                'data' => $slider
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

            $slider = Slider::findByUuid($uuid);

            if (!isset($slider->id)) {
                return RestApi::error('Slider tidak ditemukan.', 404);
            }

            $data = ['name' => $request->name];

            if(is_uploaded_file($request->image)) {
                $rules = [
                    'image' => 'required|mimes:jpg,png,jpeg|max:5120'
                ];

                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return RestApi::error($validator->messages()->first(), 400);
                }

                $images = 'SLIDER_IMAGE_'.strtoupper(str_slug($request->name, "_")).'_'.time().'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('images/slider'), $images);
                $data['image'] = $images;

                if(isset($slider->image)){
                    $img = public_path('images/slider/').$slider->image;
                    if (file_exists($img) && is_file($img)) {
                        unlink($img);
                    }
                }
            }
            


            if ($slider->update($data)) {
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
            
            $slider = Slider::findByUuid($uuid);

            if (!isset($slider->id)) {
                return RestApi::error('Slider tidak ditemukan.', 404);
            }

            if(isset($slider->image)){
                $img = public_path('images/slider/').$slider->image;
                if (file_exists($img) && is_file($img)) {
                    unlink($img);
                }
            }
            
            if ($slider->delete()) {
                return RestApi::success('Berhasil menghapus data.');
            } else {
                return RestApi::error('Gagal menghapus data.', 400);
            }
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
}
