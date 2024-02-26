<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CourseQuestion extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'course_content_id', 'question', 'a_answer', 'b_answer', 'c_answer', 'd_answer', 'answer', 'description'];
}
