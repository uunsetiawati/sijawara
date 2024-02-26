<?php

namespace App\Http\Controllers;

use DB, Validator, AppHelper, RestApi;
use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    public function show(Request $request)
    {
        $lang = [];
        if(isset($request->hl)) {
            $lang = ['lang' => $request->hl];
        }

    	$pengumuman = Pengumuman::where($lang)->get()->makeHidden(['created_at', 'updated_at', 'uuid']);
    	return RestApi::success($pengumuman);
    }

    public function index(Request $request)
    {
    	if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $pengumuman = Pengumuman::where(function($q) use ($request) {
                $q->where('content', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $pengumuman->map(function($a) {
                $a->action = '<button class="btn btn-sm btn-primary edit" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-pencil-alt"></i> Edit</button> <button class="btn btn-sm btn-danger delete" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>';
                return $a;
            });

            return response()->json($pengumuman);

        }else{
            abort(404);
        }
    }

    public function create(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $rules = [
                'content' => 'required|string',
                'lang' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }

            $pengumuman = Pengumuman::create($request->all());

            if($pengumuman) {
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
            
            $pengumuman = Pengumuman::findByUuid($uuid);

            if (!isset($pengumuman->id)) {
                return RestApi::error('Pengumuman tidak ditemukan.', 404);
            }
            
            return response()->json([
                'status' => true,
                'data' => $pengumuman
            ]);
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }

    public function update(Request $request, $uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {

            $rules = [
                'content' => 'required|string',
                'lang' => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return RestApi::error($validator->messages()->first(), 400);
            }
            
            $pengumuman = Pengumuman::findByUuid($uuid);

            if (!isset($pengumuman->id)) {
                return RestApi::error('Pengumuman tidak ditemukan.', 404);
            }

            if ($pengumuman->update($request->all())) {
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
            
            $pengumuman = Pengumuman::findByUuid($uuid);

            if (!isset($pengumuman->id)) {
                return RestApi::error('Pengumuman tidak ditemukan.', 404);
            }
            
            if ($pengumuman->delete()) {
                return RestApi::success('Berhasil menghapus data.');
            } else {
                return RestApi::error('Gagal menghapus data.', 400);
            }
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
}
