<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StandarisasiProdukTemp extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'ukm_id', 'standarisasi_produk_id', 'isi'];

    public function StandarisasiProduk()
    {
    	return $this->belongsTo(StandarisasiProduk::class, 'standarisasi_produk_id');
    }
}
