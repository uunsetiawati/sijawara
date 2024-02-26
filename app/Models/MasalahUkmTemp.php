<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasalahUkmTemp extends Model
{
   use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'ukm_id', 'masalah_ukm_id', 'isi'];

    public function MasalahUkm()
    {
        return $this->belongsTo(MasalahUkm::class, 'masalah_ukm_id');
    }
}
