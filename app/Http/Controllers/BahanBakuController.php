<?php

namespace App\Http\Controllers;

use DB, Validator, AppHelper, RestApi;
use Illuminate\Http\Request;
use App\Models\BahanBaku;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
    	if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $bahanBaku = BahanBaku::where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $bahanBaku->map(function($a) {
                $a->action = '<button class="btn btn-sm btn-primary edit" title="Edit" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Delete" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';
                return $a;
            });

            return response()->json($bahanBaku);

        }else{
            abort(404);
        }
    }

    public function show()
    {
    	$bahanBaku = BahanBaku::orderBy('id','asc')->get()->makeHidden(['created_at', 'updated_at', 'uuid']);;
    	return RestApi::success($bahanBaku);
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

            $bahanBaku = BahanBaku::create($request->all());

            if($bahanBaku) {
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
            
            $bahanBaku = BahanBaku::findByUuid($uuid);

            if (!isset($bahanBaku->id)) {
                return RestApi::error('Sumber Bahan Baku tidak ditemukan.', 404);
            }
            
            return response()->json([
                'status' => true,
                'data' => $bahanBaku
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
            
            $bahanBaku = BahanBaku::findByUuid($uuid);

            if (!isset($bahanBaku->id)) {
                return RestApi::error('Sumber Bahan Baku tidak ditemukan.', 404);
            }

            if ($bahanBaku->update($request->all())) {
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
            
            $bahanBaku = BahanBaku::findByUuid($uuid);

            if (!isset($bahanBaku->id)) {
                return RestApi::error('Sumber Bahan Baku tidak ditemukan.', 404);
            }
            
            if ($bahanBaku->delete()) {
                return RestApi::success('Berhasil menghapus data.');
            } else {
                return RestApi::error('Gagal menghapus data.', 400);
            }
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
}
