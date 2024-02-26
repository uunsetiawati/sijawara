<?php

namespace App\Http\Controllers;

use DB, Validator, AppHelper, RestApi;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function index(Request $request)
    {
    	if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $city = City::with('Province')->where(function($q) use ($request) {
            	$q->whereHas('Province', function($q) use ($request) {
            		$q->where('nm_province', 'LIKE', '%'.$request->search.'%');
            	})
            	->orWhere('nm_city', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $city->map(function($a) {
                $a->action = '<button class="btn btn-sm btn-primary edit" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';
                return $a;
            });

            return response()->json($city);

        }else{
            abort(404);
        }
    }

    public function show(Request $request)
    {
    	if ($request->province_id) {
	    	$city = City::where('province_id', $request->province_id)->orderBy('nm_city', 'ASC')->get()->makeHidden(['created_at', 'updated_at', 'province_id', 'uuid']);
	    	return RestApi::success($city);
    	}
    	$city = City::orderBy('nm_city', 'ASC')->get()->makeHidden(['created_at', 'updated_at', 'province_id', 'uuid']);
    	return RestApi::success($city);
    }

    public function create(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'nm_city' => 'required|string',
                'province_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $city = City::create($request->all());

            if($city) {
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
            
            $city = City::findByUuid($uuid);

            if (!isset($city->id)) {
                return RestApi::error('Kab/Kota tidak ditemukan.', 404);
            }
            
            return response()->json([
                'status' => true,
                'data' => $city
            ]);
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }

    public function update(Request $request, $uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {

            $rules = [
                'nm_city' => 'required|string',
                'province_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }
            
            $city = City::findByUuid($uuid);

            if (!isset($city->id)) {
                return RestApi::error('Kab/Kota tidak ditemukan.', 404);
            }

            if ($city->update($request->all())) {
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
            
            $city = City::findByUuid($uuid);

            if (!isset($city->id)) {
                return RestApi::error('Kab/Kota tidak ditemukan.', 404);
            }
            
            if ($city->delete()) {
                return RestApi::success('Berhasil menghapus data.');
            } else {
                return RestApi::error('Gagal menghapus data.', 400);
            }
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
}
