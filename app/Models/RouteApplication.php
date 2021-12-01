<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'length',
        'transport', // 0: undefined; 1: walk; 2: roadtrip; 3: community transport;
        'language', // 0: 'RUS'; 1: 'ENG';
        'photo',
        'status'
    ];

    protected $hidden = [
        'user_id',
        'city_id',
        'created_at',
        'updated_at'
    ];

    protected $appends = ['city', 'author'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function sights()
    {
        return $this->hasMany(Sight::class);
    }

    public function getCityAttribute()
    {
        $city = City::find($this->city_id);
        return $city->city;
    }

    public function getAuthorAttribute()
    {
        $user = User::find($this->user_id);
        $author = array(
            'name' => $user->first_name.' '.$user->last_name,
            'description' => $user->description,
            'avatar' => $user->avatar
        );
        return $author;
    }
}
