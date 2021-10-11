<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'length',
        'transport', // 0: undefined; 1: walk; 2: roadtrip; 3: community transport;
        'language' // 0: 'RUS'; 1: 'ENG';
    ];

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
}
