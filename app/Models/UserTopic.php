<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class UserTopic extends Model {
    use Uuid;

    protected $fillable = ['uuid', 'user_id', 'topic_id'];
}
