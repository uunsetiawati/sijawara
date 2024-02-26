<?php

namespace App\Http\Controllers;

use JWTAuth, DB, Validator, AppHelper, RestApi;
use App\Models\Ukm;
use Illuminate\Http\Request;

class UkmController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $ukm = Ukm::where(function($q) use ($request) {
                $q->where('nik', 'LIKE', '%'.$request->search.'%')
                ->orWhere('nm_pemilik', 'LIKE', '%'.$request->search.'%')
                ->orWhere('nm_ukm', 'LIKE', '%'.$request->search.'%')
                ->orWhere('phone', 'LIKE', '%'.$request->search.'%');
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $ukm->map(function($a) {
                $a->action = '<button class="btn btn-sm btn-info detail" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-eye"></i> Detail</button>';

                return $a;
            });

            return response()->json($ukm);

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

        if(strtolower($user->jenis) != 'ukm') {
            return RestApi::error('Jenis salah.', 500);
        }
        
        $ukm = Ukm::with('MasalahUkm','BahanBaku','FasKegPernah','LegalitasUsaha','StandarisasiProduk','WilayahPemasaran')->where('user_id', $user->id)->first();
        if(!isset($ukm->id)) {
            return RestApi::error('Lengkapi data terlebih dahulu.', 400, ['type' => 'ukm', 'data' => $ukm]);
        }
        $ukm->masalah_ukm = $ukm->MasalahUkm->pluck('masalah_ukm_id')->toArray();
        unset($ukm->MasalahUkm);
        $ukm->bahan_baku = $ukm->BahanBaku->pluck('bahan_baku_id')->toArray();
        unset($ukm->BahanBaku);
        $ukm->fas_keg_pernah = $ukm->FasKegPernah->pluck('fas_keg_pernah_id')->toArray();
        unset($ukm->FasKegPernah);
        $ukm->legalitas_usaha = $ukm->LegalitasUsaha->pluck('legalitas_usaha_id')->toArray();
        unset($ukm->LegalitasUsaha);
        $ukm->standarisasi_produk = $ukm->StandarisasiProduk->pluck('standarisasi_produk_id')->toArray();
        unset($ukm->StandarisasiProduk);
        $ukm->wilayah_pemasaran = $ukm->WilayahPemasaran->pluck('wilayah_pemasaran_id')->toArray();
        unset($ukm->WilayahPemasaran);

        $ukm->kapasitas_produksi = number_format($ukm->kapasitas_produksi,0,',','.');
        $ukm->volume_usaha = number_format($ukm->volume_usaha,0,',','.');
        $ukm->nilai_realisasi = number_format($ukm->nilai_realisasi,0,',','.');
        
        return RestApi::success(['type' => 'ukm', 'data' => $ukm]);
    }

    public function create(Request $request)
    {
    	$rules = [
            'nik' => 'required|min:16|max:16',
            'nm_pemilik' => 'required|string',
            'alamat_pemilik' => 'required|string',
            'tempat_lahir_pemilik' => 'required|string',
            'tanggal_lahir_pemilik' => 'required|date_format:Y-m-d',
            'jenis_kelamin_pemilik' => 'required|in:L,P',
            'pendidikan_terakhir_pemilik' => 'required|string',
            'phone' => 'required|min:9|max:15',
            'nm_ukm' => 'required|string',
            'alamat_ukm' => 'required|string',
            'province_id' => 'required',
            'city_id' => 'required',
            'kegiatan_usaha' => 'required|string',
            'produk_dihasilkan' => 'required|string',
            'kategori_ukm_id' => 'required',
            'tahun_mulai' => 'required|min:4|max:4',
            'kapasitas_produksi' => 'required',
            'volume_usaha' => 'required',
            'tenaga_pria' => 'required',
            'tenaga_wanita' => 'required',
            'badan_usaha_id' => 'required',
            'npwp' => 'required',
            'lokasi_pemasaran' => 'required',
            'nilai_realisasi' => 'required',
            'tahun_realisasi' => 'required|min:1|max:4',

            'bahan_baku' => 'array',
            'fas_keg_pernah' => 'array',
            'legalitas_usaha' => 'array',
            'masalah_ukm' => 'array',
            'standarisasi_produk' => 'array',
            'wilayah_pemasaran' => 'array',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
        	foreach ($validator->messages()->toArray() as $key => $value) {
	            return RestApi::error($value[0], 400, $key);
        	}
        }

        $checkUkm = Ukm::where('user_id', JWTAuth::user()->id)->first();
        if (isset($checkUkm->id)) {
            return RestApi::error('Data anda sudah ada.', 500);
        }

        $request['user_id'] = JWTAuth::user()->id;
        $request['kapasitas_produksi'] = str_replace('.', '', $request->kapasitas_produksi);
        $request['volume_usaha'] = str_replace('.', '', $request->volume_usaha);
        $request['nilai_realisasi'] = str_replace('.', '', $request->nilai_realisasi);

        $ukm = Ukm::create($request->all());

        if(!isset($ukm->id)) {
        	return RestApi::error('Sesuatu error terjadi.', 500);
        }

      	foreach ($request->bahan_baku as $res) {
	    	\App\Models\BahanBakuTemp::create(['ukm_id' => $ukm->id, 'bahan_baku_id' => $res]);
      	}
        $ukm->bahan_baku = $request->bahan_baku;

      	foreach ($request->fas_keg_pernah as $res) {
	    	\App\Models\FasKegPernahTemp::create(['ukm_id' => $ukm->id, 'fas_keg_pernah_id' => $res]);
      	}
        $ukm->fas_keg_pernah = $request->fas_keg_pernah;

      	foreach ($request->legalitas_usaha as $res) {
	    	\App\Models\LegalitasUsahaTemp::create(['ukm_id' => $ukm->id, 'legalitas_usaha_id' => $res]);
      	}
        $ukm->legalitas_usaha = $request->legalitas_usaha;

      	foreach ($request->masalah_ukm as $res) {
	    	\App\Models\MasalahUkmTemp::create(['ukm_id' => $ukm->id, 'masalah_ukm_id' => $res]);
      	}
        $ukm->masalah_ukm = $request->masalah_ukm;

      	foreach ($request->standarisasi_produk as $res) {
	    	\App\Models\StandarisasiProdukTemp::create(['ukm_id' => $ukm->id, 'standarisasi_produk_id' => $res]);
      	}
        $ukm->standarisasi_produk = $request->standarisasi_produk;

      	foreach ($request->wilayah_pemasaran as $res) {
	    	\App\Models\WilayahPemasaranTemp::create(['ukm_id' => $ukm->id, 'wilayah_pemasaran_id' => $res]);
      	}
        $ukm->wilayah_pemasaran = $request->wilayah_pemasaran;

        $ukm->kapasitas_produksi = number_format($ukm->kapasitas_produksi,0,',','.');
        $ukm->volume_usaha = number_format($ukm->volume_usaha,0,',','.');
        $ukm->nilai_realisasi = number_format($ukm->nilai_realisasi,0,',','.');

        return RestApi::success($ukm, 200, 'Berhasil menyimpan data');
    }

    public function update(Request $request)
    {
        $rules = [
            'uuid' => 'required|string|min:36|max:36',
            'nik' => 'required|min:16|max:16',
            'nm_pemilik' => 'required|string',
            'alamat_pemilik' => 'required|string',
            'tempat_lahir_pemilik' => 'required|string',
            'tanggal_lahir_pemilik' => 'required|date_format:Y-m-d',
            'jenis_kelamin_pemilik' => 'required|in:L,P',
            'pendidikan_terakhir_pemilik' => 'required|string',
            'phone' => 'required|min:9|max:15',
            'nm_ukm' => 'required|string',
            'alamat_ukm' => 'required|string',
            'province_id' => 'required',
            'city_id' => 'required',
            'kegiatan_usaha' => 'required|string',
            'produk_dihasilkan' => 'required|string',
            'kategori_ukm_id' => 'required',
            'tahun_mulai' => 'required|min:4|max:4',
            'kapasitas_produksi' => 'required',
            'volume_usaha' => 'required',
            'tenaga_pria' => 'required',
            'tenaga_wanita' => 'required',
            'badan_usaha_id' => 'required',
            'npwp' => 'required',
            'lokasi_pemasaran' => 'required',
            'nilai_realisasi' => 'required',
            'tahun_realisasi' => 'required|min:1|max:4',

            'bahan_baku' => 'array',
            'fas_keg_pernah' => 'array',
            'legalitas_usaha' => 'array',
            'masalah_ukm' => 'array',
            'standarisasi_produk' => 'array',
            'wilayah_pemasaran' => 'array',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            foreach ($validator->messages()->toArray() as $key => $value) {
                return RestApi::error($value[0], 400, $key);
            }
        }

        $request['user_id'] = JWTAuth::user()->id;
        $request['kapasitas_produksi'] = str_replace('.', '', $request->kapasitas_produksi);
        $request['volume_usaha'] = str_replace('.', '', $request->volume_usaha);
        $request['nilai_realisasi'] = str_replace('.', '', $request->nilai_realisasi);

        $ukm = Ukm::with('BahanBaku', 'FasKegPernah', 'LegalitasUsaha', 'MasalahUkm', 'StandarisasiProduk', 'WilayahPemasaran')->where('uuid', $request->uuid)->first();

        if(!isset($ukm->id)) {
            return RestApi::error('UKM Tidak ditemukan.', 500);
        }

        if($ukm->update($request->all())) {

            $ukm->BahanBaku->each->delete();
            foreach ($request->bahan_baku as $res) {
                \App\Models\BahanBakuTemp::create(['ukm_id' => $ukm->id, 'bahan_baku_id' => $res]);
            }

            $ukm->FasKegPernah->each->delete();
            foreach ($request->fas_keg_pernah as $res) {
                \App\Models\FasKegPernahTemp::create(['ukm_id' => $ukm->id, 'fas_keg_pernah_id' => $res]);
            }

            $ukm->LegalitasUsaha->each->delete();
            foreach ($request->legalitas_usaha as $res) {
                \App\Models\LegalitasUsahaTemp::create(['ukm_id' => $ukm->id, 'legalitas_usaha_id' => $res]);
            }

            $ukm->MasalahUkm->each->delete();
            foreach ($request->masalah_ukm as $res) {
                \App\Models\MasalahUkmTemp::create(['ukm_id' => $ukm->id, 'masalah_ukm_id' => $res]);
            }

            $ukm->StandarisasiProduk->each->delete();
            foreach ($request->standarisasi_produk as $res) {
                \App\Models\StandarisasiProdukTemp::create(['ukm_id' => $ukm->id, 'standarisasi_produk_id' => $res]);
            }

            $ukm->WilayahPemasaran->each->delete();
            foreach ($request->wilayah_pemasaran as $res) {
                \App\Models\WilayahPemasaranTemp::create(['ukm_id' => $ukm->id, 'wilayah_pemasaran_id' => $res]);
            }

            $ukm = Ukm::with('BahanBaku', 'FasKegPernah', 'LegalitasUsaha', 'MasalahUkm', 'StandarisasiProduk', 'WilayahPemasaran')->where('uuid', $request->uuid)->first();
            $ukm->masalah_ukm = $ukm->MasalahUkm->pluck('masalah_ukm_id')->toArray();
            unset($ukm->MasalahUkm);
            $ukm->bahan_baku = $ukm->BahanBaku->pluck('bahan_baku_id')->toArray();
            unset($ukm->BahanBaku);
            $ukm->fas_keg_pernah = $ukm->FasKegPernah->pluck('fas_keg_pernah_id')->toArray();
            unset($ukm->FasKegPernah);
            $ukm->legalitas_usaha = $ukm->LegalitasUsaha->pluck('legalitas_usaha_id')->toArray();
            unset($ukm->LegalitasUsaha);
            $ukm->standarisasi_produk = $ukm->StandarisasiProduk->pluck('standarisasi_produk_id')->toArray();
            unset($ukm->StandarisasiProduk);
            $ukm->wilayah_pemasaran = $ukm->WilayahPemasaran->pluck('wilayah_pemasaran_id')->toArray();
            unset($ukm->WilayahPemasaran);

            $ukm->kapasitas_produksi = number_format($ukm->kapasitas_produksi,0,',','.');
            $ukm->volume_usaha = number_format($ukm->volume_usaha,0,',','.');
            $ukm->nilai_realisasi = number_format($ukm->nilai_realisasi,0,',','.');
        
            return RestApi::success($ukm, 200, 'Berhasil menyimpan data');
        }
    }

    public function edit($uuid)
    {
        if (request()->wantsJson() && request()->ajax() && strlen($uuid) == 36) {

            $ukm = Ukm::with('MasalahUkm','BahanBaku','FasKegPernah','LegalitasUsaha','StandarisasiProduk','WilayahPemasaran')->where('uuid', $uuid)->first();

            if (!isset($ukm->id)) {
                return RestApi::error('Ukm tidak ditemukan.', 404);
            }

            $ukm->masalah_ukm = $ukm->MasalahUkm->pluck('masalah_ukm_id')->toArray();
            unset($ukm->MasalahUkm);
            $ukm->bahan_baku = $ukm->BahanBaku->pluck('bahan_baku_id')->toArray();
            unset($ukm->BahanBaku);
            $ukm->fas_keg_pernah = $ukm->FasKegPernah->pluck('fas_keg_pernah_id')->toArray();
            unset($ukm->FasKegPernah);
            $ukm->legalitas_usaha = $ukm->LegalitasUsaha->pluck('legalitas_usaha_id')->toArray();
            unset($ukm->LegalitasUsaha);
            $ukm->standarisasi_produk = $ukm->StandarisasiProduk->pluck('standarisasi_produk_id')->toArray();
            unset($ukm->StandarisasiProduk);
            $ukm->wilayah_pemasaran = $ukm->WilayahPemasaran->pluck('wilayah_pemasaran_id')->toArray();
            unset($ukm->WilayahPemasaran);

            $ukm->kapasitas_produksi = number_format($ukm->kapasitas_produksi,0,',','.');
            $ukm->volume_usaha = number_format($ukm->volume_usaha,0,',','.');
            $ukm->nilai_realisasi = number_format($ukm->nilai_realisasi,0,',','.');
            
            return RestApi::success(['type' => 'ukm', 'data' => $ukm]);
        }else{
            return RestApi::error('404 Not Found.', 404);
        }
    }
}
