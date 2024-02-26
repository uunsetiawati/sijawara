<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class NotificationTopic extends Model {
    use Uuid;

    protected $fillable = ['uuid', 'notification_id', 'topic_id'];

    public function notification() {
        return $this->belongsTo(Notification::class);
    }

    public function topic() {
        return $this->belongsTo(Topic::class);
    }
}
