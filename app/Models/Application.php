<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status' // 0: undefined; 1: requested; 2: approved; 3: declined
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}
