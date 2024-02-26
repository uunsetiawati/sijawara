<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class City extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'province_id', 'nm_city'];

    public function Province()
    {
    	return $this->belongsTo(Province::class, 'province_id');
    }
}
