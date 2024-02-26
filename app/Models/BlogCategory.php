<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'nm_category', 'lang'];
}
