<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class UserDeviceId extends Model {
    use Uuid;

    protected $fillable = ['uuid', 'device_id', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
