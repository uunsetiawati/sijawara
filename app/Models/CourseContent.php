<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class CourseContent extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'no_urut', 'course_id', 'title', 'content', 'module', 'video'];
    protected $appends = ['module_url', 'video_url'];

    public function Course()
    {
    	return $this->belongsTo(Course::class, 'course_id');
    }

    public function CourseQuestion()
    {
        return $this->hasMany(CourseQuestion::class, 'course_content_id');
    }

    public function getModuleurlAttribute()
    {
        if (filter_var($this->module, FILTER_VALIDATE_URL)) {
            return $this->module;
        }

        if(!$this->module || !is_file(public_path('uploads/modules/'.$this->module))){
            return null;
        }
        return asset('uploads/modules/'.$this->module);
    }

    // public function getImageUrlAttribute()
    // {
    //     if (filter_var($this->image, FILTER_VALIDATE_URL)) {
    //         return $this->image;
    //     }

    //     if(!$this->image || !is_file(public_path('uploads/images/'.$this->image))){
    //         return asset('assets/media/placeholder/no-image.png');
    //     }
    //     return asset('uploads/images/'.$this->image);
    // }

    public function getVideoUrlAttribute()
    {

        if (filter_var($this->video, FILTER_VALIDATE_URL)) {
            return $this->video;
        }

        if(!$this->video && !is_file(public_path('uploads/videos/'.$this->video))){
            return null;
        }

        if(is_file(public_path('uploads/videos/'.$this->video))){
            return asset('uploads/videos/'.$this->video);
        }

        return $this->video;
    }
}
