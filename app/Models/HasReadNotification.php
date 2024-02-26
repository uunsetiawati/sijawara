<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class HasReadNotification extends Model {
    use Uuid;

    protected $fillable = ['uuid', 'user_id', 'notification_id'];
    protected $with = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function notification() {
        return $this->belongsTo('App\Models\Notification');
    }
}
