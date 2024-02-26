<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['uuid', 'user_id', 'slug', 'title', 'content', 'images', 'lang'];
    protected $appends = ['image_url'];

    public function User()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function Category()
    {
    	return $this->hasMany(BlogCategoryTemp::class, 'blog_id');
    }

    public function getImageUrlAttribute()
    {
        if(!$this->images || !is_file(public_path('uploads/images/'.$this->images))){
            return asset('assets/media/placeholder/no-image.png');
        }

        return asset('uploads/images/'.$this->images);
    }
}
