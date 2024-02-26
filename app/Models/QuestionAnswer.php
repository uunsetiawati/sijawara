<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class QuestionAnswer extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'user_id', 'course_content_id', 'course_question_id', 'answer'];

    public function CourseQuestion()
    {
    	return $this->belongsTo(CourseQuestion::class, 'course_question_id');
    }
}
