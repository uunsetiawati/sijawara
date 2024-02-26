<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use Uuid;
    
    protected $fillable = ['uuid', 'name', 'image'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if(!$this->image || !is_file(public_path('images/slider/'.$this->image))){
            return asset('assets/media/placeholder/no-image.png');
        }
        return asset('images/slider/'.$this->image);
    }
}
