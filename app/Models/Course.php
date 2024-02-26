<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Course extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'nm_course', 'overview', 'module', 'image', 'status', 'user_id', 'lang'];
    protected $appends = ['module_url', 'image_url'];

    public function User()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function Category()
    {
    	return $this->hasMany(CourseCategory::class, 'course_id');
    }

    public function Categories()
    {
        return $this->belongsToMany(Category::class, 'course_categories');
    }

    public function Content()
    {
        return $this->hasMany(CourseContent::class, 'course_id');
    }

    public function CourseSection()
    {
        return $this->hasMany(CourseSection::class, 'course_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    public function getModuleUrlAttribute()
    {
        if (filter_var($this->module, FILTER_VALIDATE_URL)) {
            return $this->module;
        }

        if(!$this->module || !is_file(public_path('uploads/modules/'.$this->module))){
            return null;
        }
        return asset('uploads/modules/'.$this->module);
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
