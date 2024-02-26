<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'content', 'lang'];
}
