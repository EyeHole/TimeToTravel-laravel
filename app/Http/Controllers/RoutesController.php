<?php

namespace App\Http\Controllers;

use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoutesController extends Controller
{
    public function info($id)
    {
        $route = Route::find($id);
        return response()->json($route);
    }

    public function points($id)
    {
        $route = Route::find($id);
        $sights = $route->sights()->get();
        return response()->json(array('sights' => $sights));
    }

    public function city(Request $request, $limit, $skip)
    {
        // comment for heroku commit
        $data = $request->json()->all();
        $routes = DB::table('cities')
                    ->where('city', '=', $data['city'])
                    ->join('routes', 'cities.id', '=', 'routes.city_id')
                    ->join('users', 'routes.user_id', '=', 'users.id')
                    ->join('sights', 'sights.route_id', '=', 'routes.id')
                    ->where('sights.priority', '=', '1')
                    ->select('routes.*', 'sights.latitude', 'sights.longitude', 
                                'users.first_name', 'users.last_name', 
                                'users.description as user_description')
                    ->get()->toArray();

        $sinLat = sin(deg2rad(floatval($data['latitude'])));
        $cosLat = cos(deg2rad(floatval($data['latitude'])));

        usort($routes, function($a, $b) use ($sinLat, $cosLat, $data) {

            return acos($sinLat * sin(deg2rad(floatval($a->latitude))) + $cosLat * cos(deg2rad(floatval($a->latitude))) 
                * cos(deg2rad(floatval($data['longitude']))-deg2rad(floatval($a->longitude)))) <
                acos($sinLat * sin(deg2rad(floatval($b->latitude))) + $cosLat * cos(deg2rad(floatval($b->latitude))) 
                * cos(deg2rad(floatval($data['longitude']))-deg2rad(floatval($b->longitude))));
        });

        $routes = array_slice($routes, $limit, $skip);

        $routes = array_map( function($item) {
            return (object) array(
                "id"=> $item->id,
                "name"=> $item->name,
                "description"=> $item->description,
                "length"=> $item->length,
                "transport"=> $item->transport,
                "language"=> $item->language,
                "photo"=> $item->photo,
                "author"=> (object) array(
                    "name"=> $item->first_name . ' ' . $item->last_name,
                    "description"=> $item->user_description
                ),
            );
        }, $routes);

        return response()->json($routes);
    }

    public function create()
    {
        //
    }

    public function update(Request $request, Route $route)
    {
        //
    }

    public function delete(Route $route)
    {
        //
    }
}
