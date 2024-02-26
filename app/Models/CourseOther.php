<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CourseOther extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'title', 'description', 'is_online', 'username', 'password', 'meeting_url', 'place', 'date_start', 'date_end', 'time_start', 'time_end', 'is_active', 'quota', 'image', 'lang'];
    protected $appends = ['image_url'];

    public function Category()
    {
        return $this->hasMany(CourseCategory::class, 'course_other_id');
    }

    public function Categories()
    {
        return $this->belongsToMany(Category::class, 'course_categories');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '1');
    }

    public function CourseSection()
    {
        return $this->hasMany(CourseSection::class, 'course_other_id');
    }

    public function getImageUrlAttribute()
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if(!$this->image || !is_file(public_path('uploads/images/'.$this->image))){
            return asset('assets/media/placeholder/no-image.png');
        }
        return asset('uploads/images/'.$this->image);
    }
}
