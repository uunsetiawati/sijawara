<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasalahKoperasi extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'name'];

    public function MasalahKoperasi()
    {
    	return $this->hasMany(MasalahKoperasiTemp::class, 'koperasi_id');
    }
}
