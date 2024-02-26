<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokKoperasi extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'name'];
}
