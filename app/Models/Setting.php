<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;

class Setting extends Model
{
    use Uuid;

    protected $fillable = ['uuid', 'name', 'background', 'logo_dark', 'logo_white', 'description', 'lang'];
    protected $appends = ['backgrounddir', 'logodarkdir', 'logowhitedir'];

    public function getBackgrounddirAttribute()
    {
    	if(!$this->background || !is_file(public_path('images/background/'.$this->background))) {
            return asset('/assets/media/bg/bg-mcflyon.png');
        }
        return asset('images/background/'.$this->background);
    }

    public function getLogodarkdirAttribute()
    {
    	if(!$this->logo_dark || !is_file(public_path('images/logo/'.$this->logo_dark))) {
            return asset('/assets/media/logos/logo-dark.png');
        }
        return asset('images/logo/'.$this->logo_dark);
    }

    public function getLogowhitedirAttribute()
    {
    	if(!$this->logo_white || !is_file(public_path('images/logo/'.$this->logo_white))) {
            return asset('/assets/media/logos/logo-dark.png');
        }
        return asset('images/logo/'.$this->logo_white);
    }
}