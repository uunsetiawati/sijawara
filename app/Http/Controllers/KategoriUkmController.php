<?php

namespace App\Http\Controllers;

use DB, Validator, AppHelper, RestApi;
use Illuminate\Http\Request;
use App\Models\KategoriUkm;

class KategoriUkmController extends Controller
{
    public function index(Request $request)
    {
    	if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $kategoriUkm = KategoriUkm::where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $kategoriUkm->map(function($a) {
                $a->action = '<button class="btn btn-sm btn-primary edit" title="Edit" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Delete" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';
                return $a;
            });

            return response()->json($kategoriUkm);

        }else{
            abort(404);
        }
    }

    public function show()
    {
    	$kategoriUkm = KategoriUkm::orderBy('name', 'ASC')->get()->makeHidden(['created_at', 'updated_at', 'uuid']);;
    	return RestApi::success($kategoriUkm);
    }

    public function create(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'name' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $kategoriUkm = KategoriUkm::create($request->all());

            if($kategoriUkm) {
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
            
            $kategoriUkm = KategoriUkm::findByUuid($uuid);

            if (!isset($kategoriUkm->id)) {
                return RestApi::error('Kategori UKM tidak ditemukan.', 404);
            }
            
            return response()->json([
                'status' => true,
                'data' => $kategoriUkm
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
            
            $kategoriUkm = KategoriUkm::findByUuid($uuid);

            if (!isset($kategoriUkm->id)) {
                return RestApi::error('Kategori UKM tidak ditemukan.', 404);
            }

            if ($kategoriUkm->update($request->all())) {
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
            
            $kategoriUkm = KategoriUkm::findByUuid($uuid);

            if (!isset($kategoriUkm->id)) {
                return RestApi::error('Kategori UKM tidak ditemukan.', 404);
            }
            
            if ($kategoriUkm->delete()) {
                return RestApi::success('Berhasil menghapus data.');
            } else {
                return RestApi::error('Gagal menghapus data.', 400);
            }
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
}
