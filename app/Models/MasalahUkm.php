<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasalahUkm extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'name'];
}
