<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    use Uuid;

    protected $fillable = ['uuid', 'judul', 'isi', 'image', 'onclick', 'target'];
    protected $appends = ['image_url'];
    protected $hidden = ['pivot'];

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

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'notification_topics');
    }
}
