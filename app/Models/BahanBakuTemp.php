<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBakuTemp extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'ukm_id', 'bahan_baku_id'];

    public function BahanBaku()
    {
    	return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }
}
