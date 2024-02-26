<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use Uuid;

    protected $fillable = [
        'uuid', 'name', 'gender', 'position', 'phone', 'birth_place', 'birth_date', 'email', 'password', 'image', 'province_id', 'city_id', 'level', 'otp', 'otp_expire', 'active', 'nik', 'jabatan', 'instansi', 'jenis', 'address', 'oauth_id'];
    protected $appends = ['image_url'];

    protected $hidden = [
        'password', 'remember_token', 'otp', 'otp_expire', 'position', 'pivot'
    ];

    public function City()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function Province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function Ukm()
    {
        return $this->hasOne(Ukm::class, 'user_id');
    }

    public function Koperasi()
    {
        return $this->hasOne(Koperasi::class, 'user_id');
    }

    public function has_read_notifications()
    {
        return $this->belongsToMany(Notification::class, 'has_read_notifications');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'user_topics');
    }

    public function device_ids()
    {
        return $this->hasMany(UserDeviceId::class, 'user_id');
    }

    public function courses()
    {
        return $this->hasMany(CourseSection::class);
    }

    public function getImageurlAttribute()
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        if(!$this->image || !is_file(public_path('uploads/images/'.$this->image))){
            if($this->gender == '0') {
                return asset('assets/media/placeholder/no-image.png');
            }else if($this->gender == '1') {
                return asset('assets/media/placeholder/no-image.png');
            }
            return asset('assets/media/placeholder/no-image.png');
        }
        return asset('uploads/images/'.$this->image);
    }

    public function scopeActive($query)
    {
        return $query->where('active', '1');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
