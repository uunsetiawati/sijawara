<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Widyaiswara extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'name', 'position', 'about', 'photo', 'popup'];
    protected $appends = ['photo_url', 'popup_url'];

    public function getPhotourlAttribute()
    {
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }

        if (isset($this->photo)) {
            return asset('uploads/widyaiswara/'.$this->photo);
        } 
    }

    public function getPopupurlAttribute()
    {
        if (filter_var($this->popup, FILTER_VALIDATE_URL)) {
            return $this->popup;
        }

        if (isset($this->popup)) {
            return asset('uploads/widyaiswaras/'.$this->popup);
        }
    }
}
