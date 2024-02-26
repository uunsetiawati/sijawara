<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ukm extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'user_id', 'nik', 'nm_pemilik', 'alamat_pemilik', 'tempat_lahir_pemilik', 'tanggal_lahir_pemilik', 'jenis_kelamin_pemilik', 'pendidikan_terakhir_pemilik', 'phone', 'nm_ukm', 'alamat_ukm', 'province_id', 'city_id', 'kegiatan_usaha', 'produk_dihasilkan', 'kategori_ukm_id', 'tahun_mulai', 'kapasitas_produksi', 'volume_usaha', 'tenaga_pria', 'tenaga_wanita', 'badan_usaha_id', 'npwp', 'lokasi_pemasaran', 'nilai_realisasi', 'tahun_realisasi'];

    public function BahanBaku()
    {
    	return $this->hasMany(BahanBakuTemp::class, 'bahan_baku_id');
    }

    public function FasKegPernah()
    {
    	return $this->hasMany(FasKegPernahTemp::class, 'fas_keg_pernah_id');
    }

    public function LegalitasUsaha()
    {
    	return $this->hasMany(LegalitasUsahaTemp::class, 'legalitas_usaha_id');
    }

    public function MasalahUkm()
    {
    	return $this->hasMany(MasalahUkmTemp::class, 'masalah_ukm_id');
    }

    public function StandarisasiProduk()
    {
    	return $this->hasMany(StandarisasiProdukTemp::class, 'standarisasi_produk_id');
    }

    public function WilayahPemasaran()
    {
    	return $this->hasMany(WilayahPemasaranTemp::class, 'wilayah_pemasaran_id');
    }

    public function City()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function Province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function KategoriUkm()
    {
        return $this->belongsTo(KategoriUkm::class, 'kategori_ukm_id');
    }

    public function BadanUsaha()
    {
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }
}
