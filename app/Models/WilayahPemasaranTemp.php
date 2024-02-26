<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WilayahPemasaranTemp extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'ukm_id', 'wilayah_pemasaran_id', 'isi'];

    public function WilayahPemasaran()
    {
    	return $this->belongsTo(WilayahPemasaran::class, 'wilayah_pemasaran_id');
    }
}
