<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sight extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'priority',
        'photos',
        'audio'
    ];

    protected $hidden = [
        'route_id',
        'created_at',
        'updated_at'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
