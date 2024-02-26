<?php

namespace App\Http\Controllers;

use JWTAuth, DB, Validator, AppHelper, RestApi;
use App\Models\Koperasi;
use Illuminate\Http\Request;

class KoperasiController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $koperasi = Koperasi::where(function($q) use ($request) {
                if ($request->search == 'aktif') {
                    $q->where('status', '1');
                } else if ($request->search == 'tidak') {
                    $q->where('status', '0');
                } else {
                    $q->where('nik', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('nm_ketua', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('nm_koperasi', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('phone', 'LIKE', '%'.$request->search.'%');
                }
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $koperasi->map(function($a) {
                $a->action = '<button class="btn btn-sm btn-info detail" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-eye"></i> Detail</button>';

                switch ($a->status) {
                    case 0:
                        $a->status = '<span class="label label-lg label-light-danger label-inline">TIDAK</span>';
                        break;

                    case 1:
                        $a->status = '<span class="label label-lg label-light-success label-inline">AKTIF</span>';
                        break;
                }

                return $a;
            });

            return response()->json($koperasi);

        }else{
            abort(404);
        }
    }

    public function check(Request $request)
    {
    	$user = \App\Models\User::find(JWTAuth::user()->id);
        if(!isset($user->id)) {
            return RestApi::error('User tidak ditemukan.', 404);
        }

        if(strtolower($user->jenis) != 'koperasi') {
            return RestApi::error('Jenis salah.', 500);
        }
        
        $koperasi = Koperasi::with('MasalahKoperasi')->where('user_id', $user->id)->first();
        if(!isset($koperasi->id)) {
            return RestApi::error('Lengkapi data terlebih dahulu.', 400, ['type' => 'koperasi', 'data' => $koperasi]);
        }
        $koperasi->masalah_koperasi = $koperasi->MasalahKoperasi->pluck('masalah_koperasi_id')->toArray();
        unset($koperasi->MasalahKoperasi);
        $koperasi->asset = number_format($koperasi->asset,0,',','.');
        $koperasi->volume_usaha = number_format($koperasi->volume_usaha,0,',','.');
        $koperasi->modal_sendiri = number_format($koperasi->modal_sendiri,0,',','.');
        $koperasi->modal_luar = number_format($koperasi->modal_luar,0,',','.');
        $koperasi->sisa_hasil_usaha = number_format($koperasi->sisa_hasil_usaha,0,',','.');
        return RestApi::success(['type' => 'koperasi', 'data' => $koperasi]);
   }

    public function create(Request $request)
    {
    	$rules = [
	    	'alamat_koperasi' => 'required',
	    	'anggota_pria' => 'required',
	    	'anggota_wanita' => 'required',
	    	'asset' => 'required',
	    	'nik' => 'required|min:1',
	    	'nm_koperasi' => 'required|string',
	    	'province_id' => 'required',
	    	'city_id' => 'required',
	    	'phone' => 'required|min:1|max:15',
	    	'no_badan_hukum' => 'required',
	    	'tgl_badan_hukum' => 'required',
	    	'status' => 'required',
	    	'cabang' => 'required',
	    	'tgl_rat' => 'required',
	    	'nm_ketua' => 'required',
	    	'phone_ketua' => 'required',
	    	'nm_sekretaris' => 'required',
	    	'phone_sekretaris' => 'required',
	    	'nm_bendahara' => 'required',
	    	'phone_bendahara' => 'required',
	    	'manager_pria' => 'required',
	    	'manager_wanita' => 'required',
	    	'karyawan_pria' => 'required',
	    	'karyawan_wanita' => 'required',
	    	'bentuk_koperasi_id' => 'required',
	    	'jenis_koperasi_id' => 'required',
	    	'kelompok_koperasi_id' => 'required',
	    	'sektor_usaha_id' => 'required',
	    	'volume_usaha' => 'required',
	    	'unit_usaha_id' => 'required',
	    	'modal_sendiri' => 'required',
	    	'modal_luar' => 'required',
	    	'sisa_hasil_usaha' => 'required',

	    	'masalah_koperasi' => 'array',
	    ];

	    $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
        	foreach ($validator->messages()->toArray() as $key => $value) {
	            return RestApi::error($value[0], 400, $key);
        	}
        }

        $checkKoperasi = Koperasi::where('user_id', JWTAuth::user()->id)->first();
        if (isset($checkKoperasi->id)) {
            return RestApi::error('Data anda sudah ada.', 500);
        }

        $request['user_id'] = JWTAuth::user()->id;
        $request['asset'] = str_replace('.', '', $request->asset);
        $request['volume_usaha'] = str_replace('.', '', $request->volume_usaha);
        $request['modal_sendiri'] = str_replace('.', '', $request->modal_sendiri);
        $request['modal_luar'] = str_replace('.', '', $request->modal_luar);
        $request['sisa_hasil_usaha'] = str_replace('.', '', $request->sisa_hasil_usaha);

        $koperasi = Koperasi::create($request->all());

        foreach ($request->masalah_koperasi as $res) {
	    	\App\Models\MasalahKoperasiTemp::create(['koperasi_id' => $koperasi->id, 'masalah_koperasi_id' => $res]);
      	}

        $koperasi->masalah_koperasi = $request->masalah_koperasi;

        $koperasi->asset = number_format($koperasi->asset,0,',','.');
        $koperasi->volume_usaha = number_format($koperasi->volume_usaha,0,',','.');
        $koperasi->modal_sendiri = number_format($koperasi->modal_sendiri,0,',','.');
        $koperasi->modal_luar = number_format($koperasi->modal_luar,0,',','.');
        $koperasi->sisa_hasil_usaha = number_format($koperasi->sisa_hasil_usaha,0,',','.');

        return RestApi::success($koperasi, 200, 'Berhasil menyimpan data');

    }

    public function update(Request $request)
    {
        $rules = [
            'alamat_koperasi' => 'required',
            'anggota_pria' => 'required',
            'anggota_wanita' => 'required',
            'asset' => 'required',
            'nik' => 'required|min:1',
            'nm_koperasi' => 'required|string',
            'province_id' => 'required',
            'city_id' => 'required',
            'phone' => 'required|min:1|max:15',
            'no_badan_hukum' => 'required',
            'tgl_badan_hukum' => 'required',
            'status' => 'required',
            'cabang' => 'required',
            'tgl_rat' => 'required',
            'nm_ketua' => 'required',
            'phone_ketua' => 'required',
            'nm_sekretaris' => 'required',
            'phone_sekretaris' => 'required',
            'nm_bendahara' => 'required',
            'phone_bendahara' => 'required',
            'manager_pria' => 'required',
            'manager_wanita' => 'required',
            'karyawan_pria' => 'required',
            'karyawan_wanita' => 'required',
            'bentuk_koperasi_id' => 'required',
            'jenis_koperasi_id' => 'required',
            'kelompok_koperasi_id' => 'required',
            'sektor_usaha_id' => 'required',
            'volume_usaha' => 'required',
            'unit_usaha_id' => 'required',
            'modal_sendiri' => 'required',
            'modal_luar' => 'required',
            'sisa_hasil_usaha' => 'required',

            'masalah_koperasi' => 'array',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) {
                return RestApi::error($value[0], 400, $key);
            }
        }

        $request['user_id'] = JWTAuth::user()->id;
        $request['asset'] = str_replace('.', '', $request->asset);
        $request['volume_usaha'] = str_replace('.', '', $request->volume_usaha);
        $request['modal_sendiri'] = str_replace('.', '', $request->modal_sendiri);
        $request['modal_luar'] = str_replace('.', '', $request->modal_luar);
        $request['sisa_hasil_usaha'] = str_replace('.', '', $request->sisa_hasil_usaha);

        $koperasi = Koperasi::with('MasalahKoperasi')->where('uuid', $request->uuid)->first();

        if(!isset($koperasi->id)) {
            return RestApi::error('Koperasi Tidak ditemukan.', 500);
        }

        if($koperasi->update($request->all())) {

            $koperasi->MasalahKoperasi->each->delete();
            foreach ($request->masalah_koperasi as $res) {
                \App\Models\MasalahKoperasiTemp::create(['koperasi_id' => $koperasi->id, 'masalah_koperasi_id' => $res]);
            }

            $koperasi = Koperasi::with('MasalahKoperasi')->where('uuid', $request->uuid)->first();

            $koperasi->asset = number_format($koperasi->asset,0,',','.');
            $koperasi->volume_usaha = number_format($koperasi->volume_usaha,0,',','.');
            $koperasi->modal_sendiri = number_format($koperasi->modal_sendiri,0,',','.');
            $koperasi->modal_luar = number_format($koperasi->modal_luar,0,',','.');
            $koperasi->sisa_hasil_usaha = number_format($koperasi->sisa_hasil_usaha,0,',','.');

            $koperasi->masalah_koperasi = $koperasi->MasalahKoperasi->pluck('masalah_koperasi_id')->toArray();
            unset($koperasi->MasalahKoperasi);

            return RestApi::success($koperasi, 200, 'Berhasil menyimpan data');
        }

    }

    public function edit($uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {

            $koperasi = Koperasi::with('MasalahKoperasi')->where('uuid', $uuid)->first();

            if (!isset($koperasi->id)) {
                return RestApi::error('koperasi tidak ditemukan.', 404);
            }
            
            $koperasi->masalah_koperasi = $koperasi->MasalahKoperasi->pluck('masalah_koperasi_id')->toArray();
            unset($koperasi->MasalahKoperasi);
            $koperasi->asset = number_format($koperasi->asset,0,',','.');
            $koperasi->volume_usaha = number_format($koperasi->volume_usaha,0,',','.');
            $koperasi->modal_sendiri = number_format($koperasi->modal_sendiri,0,',','.');
            $koperasi->modal_luar = number_format($koperasi->modal_luar,0,',','.');
            $koperasi->sisa_hasil_usaha = number_format($koperasi->sisa_hasil_usaha,0,',','.');
            return RestApi::success(['type' => 'koperasi', 'data' => $koperasi]);
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
}
