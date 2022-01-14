<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';
    public $timestamps = false;

    protected $fillable = [
        'city',
        'country'
    ];

    public static function create($name, $country) {
        $city = new City();
    
        $city['city'] = $name;
        $city['country'] = $country;
        $city->save();

        return $city['id'];
    }

    public static function getByName($name) {
        return City::where('city', '=', $name)->first();
    }
}
