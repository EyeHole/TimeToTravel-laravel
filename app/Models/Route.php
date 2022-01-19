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
        'language', // 0: 'RUS'; 1: 'ENG';
        'photo'
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
            'name' => $user->name.' '.$user->surname,
            'description' => $user->description,
            'avatar' => $user->avatar
        );
        return $author;
    }

    public static function create($route_data) {
        $route = new Route();
    
        $route['name'] = $route_data['name'];
        $route['description'] = $route_data['description'];
        $route['transport'] = $route_data['transport'];
        $route['user_id'] = $route_data['user_id'];
        $route['city_id'] = $route_data['city_id'];
    
        if (isset($route_data['photo'])) {
            $route['photo'] = $route_data['photo'];
        }

        $route->save();
        return $route['id'];
    }

    public static function getRoutesByCity($city) {
        return DB::table('cities')
            ->where('city', '=', $data['city'])
            ->join('routes', 'cities.id', '=', 'routes.city_id')
            ->join('users', 'routes.user_id', '=', 'users.id')
            ->join('sights', 'sights.route_id', '=', 'routes.id')
            ->where('sights.priority', '=', '1')
            ->select(
                'routes.*',
                'sights.latitude',
                'sights.longitude',
                'users.name',
                'users.surname',
                'users.description as user_description'
            )
            ->get()->toArray();
    }

    public static function addCity($id, $city) {
        $route = Route::find($id);
        $route['city_id'] = $city;
        $route->save();
    }

    public static function addLength($id, $length) {
        $route = Route::find($id);
        $route['length'] = $length;
        $route->save();
    }
}
