<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model {
    use Uuid;

    protected $fillable = ['uuid', 'name', 'slug'];

    protected $hidden = ['pivot'];

    public function users() {
        return $this->belongsToMany(User::class, 'user_topics');
    }

    public function notifications() {
        return $this->belongsToMany(Notification::class, 'notification_topics');
    }
}
