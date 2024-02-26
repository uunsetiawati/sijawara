<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Province extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'nm_province'];
}
