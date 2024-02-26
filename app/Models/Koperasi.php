<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koperasi extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'user_id', 'nik', 'nm_koperasi', 'alamat_koperasi', 'province_id', 'city_id', 'phone', 'no_badan_hukum', 'tgl_badan_hukum', 'no_pad', 'tgl_pad', 'status', 'cabang', 'tgl_rat', 'nm_ketua', 'phone_ketua', 'nm_sekretaris', 'phone_sekretaris', 'nm_bendahara', 'phone_bendahara', 'anggota_pria', 'anggota_wanita', 'manager_pria', 'manager_wanita', 'karyawan_pria', 'karyawan_wanita', 'bentuk_koperasi_id', 'jenis_koperasi_id', 'kelompok_koperasi_id', 'sektor_usaha_id', 'volume_usaha', 'asset', 'unit_usaha_id', 'modal_sendiri', 'modal_luar', 'sisa_hasil_usaha'];

    public function MasalahKoperasi()
    {
    	return $this->hasMany(MasalahKoperasiTemp::class, 'koperasi_id');
    }

    public function User()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function City()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function Province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function BentukKoperasi()
    {
        return $this->belongsTo(BentukKoperasi::class, 'bentuk_koperasi_id');
    }

    public function JenisKoperasi()
    {
        return $this->belongsTo(JenisKoperasi::class, 'jenis_koperasi_id');
    }

    public function KelompokKoperasi()
    {
        return $this->belongsTo(KelompokKoperasi::class, 'kelompok_koperasi_id');
    }

    public function SektorUsaha()
    {
        return $this->belongsTo(SektorUsaha::class, 'sektor_usaha_id');
    }

    public function UnitUsaha()
    {
        return $this->belongsTo(UnitUsaha::class, 'unit_usaha_id');
    }
}
