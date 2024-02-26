<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasalahKoperasiTemp extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'koperasi_id', 'masalah_koperasi_id'];

    public function MasalahKoperasi()
    {
        return $this->belongsTo(MasalahKoperasi::class, 'masalah_koperasi_id');
    }
}
