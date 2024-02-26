<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategoryTemp extends Model
{
    use \App\Traits\Uuid;

    protected $fillable = ['blog_id', 'blog_category_id'];

    public function Blog()
    {
    	return $this->belongsTo(Blog::class, 'blog_id');
    }

    public function Category()
    {
    	return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
}
