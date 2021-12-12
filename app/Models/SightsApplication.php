<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SightsApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'priority',
        'photos',
        'audio',
        'status' // 0: undefined; 1: requested; 2: approved; 3: declined
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
