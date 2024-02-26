<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalitasUsahaTemp extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'ukm_id', 'legalitas_usaha_id', 'isi'];

    public function LegalitasUsaha()
    {
    	return $this->belongsTo(LegalitasUsaha::class, 'legalitas_usaha_id');
    }
}
