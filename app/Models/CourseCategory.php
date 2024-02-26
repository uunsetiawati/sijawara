<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CourseCategory extends Model
{
    use Uuid;

    protected $fillable = ['course_id', 'course_other_id', 'category_id'];

    public function Course()
    {
    	return $this->belongsTo(Course::class, 'course_id');
    }

    public function CourseOther()
    {
        return $this->belongsTo(CourseOther::class, 'course_other_id');
    }

    public function Category()
    {
    	return $this->belongsTo(Category::class, 'category_id');
    }
}
