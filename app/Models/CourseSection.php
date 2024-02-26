<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CourseSection extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'user_id', 'course_id', 'course_other_id', 'section', 'status', 'nilai', 'is_remidi', 'no_urut'];

    public function User()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function Course()
    {
    	return $this->belongsTo(Course::class, 'course_id');
    }

    public function CourseOther()
    {
        return $this->belongsTo(CourseOther::class, 'course_other_id');
    }
}
