<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FasKegPernahTemp extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'ukm_id', 'fas_keg_pernah_id', 'isi'];

    public function FasKegPernah()
    {
    	return $this->belongsTo(FasKegPernah::class, 'fas_keg_pernah_id');
    }
}
