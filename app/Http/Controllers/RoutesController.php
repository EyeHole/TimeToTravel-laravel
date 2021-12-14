<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Sight;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        // dd(DB::table('cities')->get());
        $data = $request->json()->all();
        $routes = DB::table('cities')
            ->where('city', '=', $data['city'])
            ->join('routes', 'cities.id', '=', 'routes.city_id')
            ->join('users', 'routes.user_id', '=', 'users.id')
            ->join('sights', 'sights.route_id', '=', 'routes.id')
            ->where('sights.priority', '=', '1')
            ->select(
                'routes.*',
                'sights.latitude',
                'sights.longitude',
                'users.first_name',
                'users.last_name',
                'users.description as user_description'
            )
            ->get()->toArray();

        $sinLat = sin(deg2rad(floatval($data['latitude'])));
        $cosLat = cos(deg2rad(floatval($data['latitude'])));

        usort($routes, function ($a, $b) use ($sinLat, $cosLat, $data) {

            return acos($sinLat * sin(deg2rad(floatval($a->latitude))) + $cosLat * cos(deg2rad(floatval($a->latitude)))
                * cos(deg2rad(floatval($data['longitude'])) - deg2rad(floatval($a->longitude)))) <
                acos($sinLat * sin(deg2rad(floatval($b->latitude))) + $cosLat * cos(deg2rad(floatval($b->latitude)))
                    * cos(deg2rad(floatval($data['longitude'])) - deg2rad(floatval($b->longitude))));
        });

        $routes = array_slice($routes, $skip, $limit);

        $routes = array_map(function ($item) {
            return (object) array(
                "id" => $item->id,
                "name" => $item->name,
                "description" => $item->description,
                "length" => $item->length,
                "transport" => $item->transport,
                "language" => $item->language,
                "photo" => $item->photo,
                "author" => (object) array(
                    "name" => $item->first_name . ' ' . $item->last_name,
                    "description" => $item->user_description
                ),
            );
        }, $routes);

        return response()->json($routes);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'mainImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $route = new Route();
        $route['name'] = $request->input('name');
        $route['description'] = $request->input('description');
        $route['transport'] = $request->input('transport');

        if ($request->hasFile('mainImage')) {
            $path = $request->file('mainImage')->storePublicly('routes', 'public');
            $route['photo'] = 'storage/' . $path;
        }
        if (Auth::check()) {
            $route['user_id'] = Auth::id();
        } else {
            return redirect()->route('login');
        }

        $route['city_id'] = 1; // id = 1 - Unknown
        $route->save();

        $id = $route['id'];
        session(['route_id' => $id]);
        return redirect()->route('place');
    }

    function getLocationNames($lat, $long) {
        $get_API = "https://maps.googleapis.com/maps/api/geocode/json?latlng=";
        $get_API .= round($lat,4).",".round($long,4).'&language=ru&sensor=false&key='.env('GOOGLE_MAPS_API_KEY');        

        $jsonfile = file_get_contents($get_API);
        $jsonarray = json_decode($jsonfile);

        $city = 'Unknown';
        $country = 'Unknown';
    
        if (isset($jsonarray->results[1]->address_components)) {
            foreach($jsonarray->results[1]->address_components as $elem) {
                if ($elem->types[0] == 'locality') {
                    $city = $elem->long_name;
                }
                if ($elem->types[0] == 'country') {
                    $country = $elem->long_name;
                }
            }
        }
        return [$city, $country];
    }

    public function showPlace(int $route_id, int $order, int $length)
    {
        $sight = Sight::where([
            ['route_id', '=', $route_id],
            ['priority', '=', $order],
        ])->first();
        if ($sight == null) {
            $longitude = "";
            $latitude = "";
            $name = "";
            $description = "";
            $photos = [];
            $audio = "";
        } else {
            $longitude = $sight['longitude'];
            $latitude = $sight['latitude'];
            $name = $sight['name'];
            $description = $sight['description'];
            $photos = json_decode($sight['photos']);
            $audio = json_decode($sight['audio']);
        }

        return view("trip/places", compact('route_id', 'order', 'length', 'longitude', 'latitude', 'name', 'description', 'photos', 'audio'));
    }

    function addCityToRoute($trip_id) {
        $place = Sight::where([
            ['route_id', '=', $trip_id],
            ['priority', '=', 1]
        ])->first();

        $lat = $place['latitude'];
        $long = $place['longitude'];

        list($city_name, $country_name) = $this->getLocationNames($lat, $long);
        $city = City::where('city', '=', $city_name)->first();
        if ($city == null) {
            $city = new City();
            $city['city'] = $city_name;
            $city['country'] = $country_name;
            $city->save();
        }
    
        $route = Route::find($trip_id);
        $route['city_id'] = $city['id'];
        $route->save();
        return;
    }

    function getDistance($route_id) {
        $sights = Sight::where([
            ['route_id', '=', $route_id],
        ])->orderBy('priority', 'ASC')->get();


        $distanceUrl = 'https://maps.googleapis.com/maps/api/directions/json?'.
        'origin='.$sights->first()['latitude'].','.$sights->first()['longitude'].
        '&destination='.$sights->last()['latitude'].','.$sights->last()['longitude']
        .'&waypoints=';

        foreach($sights as $sight) {
            $distanceUrl .= $sight['latitude'].','.$sight['longitude'].'|';
        } 

        $route = Route::find($route_id);
        if ($route != null) {
            switch ($route['transport']) {
                case 1:
                    $distanceUrl .='&mode=walking';
                    break;
                case 3:
                    $distanceUrl .='&mode=transit';
                    break;
            }
        }
        
        $distanceUrl .= '&key='.env('GOOGLE_MAPS_API_KEY');
        $jsonfile = file_get_contents($distanceUrl);
        $jsonarray = json_decode($jsonfile);

        $distance = 0;
        if (isset($jsonarray->routes[0]) && isset($jsonarray->routes[0]->legs)) {
            foreach($jsonarray->routes[0]->legs as $elem) {
                $distance += $elem->distance->value;
            }
        }
        return $distance;
    }

    function deletePlace($trip_id, $order) {
        $place = Sight::where([
            ['route_id', '=', $trip_id],
            ['priority', '=', $order]
        ]);

        if ($place != null) {
            $place->delete();
        
            $places = Sight::where([
                ['route_id', '=', $trip_id],
                ['priority', '>', $order]
            ])->get();

            foreach ($places as $elem) {
                error_log($elem['name']);
                $elem['priority'] -= 1;
                $elem->save();
            }
        }
    }

    public function addPlace(Request $request)
    {
        $trip_id = $request->input('trip_id');
        $order = $request->input('order');
        $length = $request->input('length');

        switch ($request->input('action')) {
            case 'prev':
                return $this->showPlace($trip_id, $order-1, $length);
            case 'next':
                return $this->showPlace($trip_id, $order+1, $length);
            case 'delete':
                $this->deletePlace($trip_id, $order);
                if ($order == 1) {
                    $order += 1;
                }
                return $this->showPlace($trip_id, $order-1, $length-1);
        }

        $request->validate([
            'name' => 'required|max:255',
            'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'audio' => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav,aac'
        ]);

        $place = Sight::where([
            ['priority', '=', $order],
            ['route_id', '=', $trip_id]
        ])->first();
        if ($place == null) {
            $place = new Sight();
        }

        $place['name'] = $request->input('name');
        $place['description'] = $request->input('description');
        $place['latitude'] = $request->input('latitude');
        $place['longitude'] = $request->input('longitude');
        $place['priority'] = $order;
        $place['route_id'] = $trip_id;

        $image_paths = [];
        if ($request->has('uploaded_images')) {
            foreach ($request->uploaded_images as $uploaded_image_url) {
                array_push($image_paths, $uploaded_image_url);
            }
        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->storePublicly('sights/' . $trip_id . '/images', 'public');
                array_push($image_paths, 'storage/' . $path);
            }
        }
        $place['photos'] = json_encode($image_paths);

        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->storePublicly('sights/' . $trip_id . '/audio', 'public');
            $place['audio'] = json_encode('storage/' . $path);
        }

        $place->save();
        switch($request->input('action')) {
            case 'save':
                return $this->showPlace($trip_id, $order, $length);
            case 'new':
                return $this->showPlace($trip_id, $length+1, $length+1);
            case 'end':
                $this->addCityToRoute($trip_id);
                $route = Route::find($trip_id);
                $route['length'] = $this->getDistance($trip_id);
                $route->save();
                break;
        }
    
        return $this->showTripInfo($trip_id);
    }

    public function showTripInfo(int $trip_id)
    {
        $route = Route::find($trip_id);
        $name = $route['name'];
        $description = $route['description'];
        $option = $route['transport'];
        $length = Sight::where([['route_id', '=', $trip_id]])->count();

        return view("trip/overview", compact('length', 'name', 'description', 'option'));
    }

    public function repopulatePlaces(Request $request) {
        $route_id = $request->session()->get('route_id');
        $order = $request->old('order');
        if (!$order) {
            $order = 1;
        }

        $length = $request->old('length');
        if (!$length) {
            $length = 1;
        }
    
        $longitude = $request->old('longitude');
        $latitude = $request->old('latitude');
        $name = $request->old('name');
        $description = $request->old('description');

        return view("trip/places", compact('route_id', 'order', 'length', 'longitude', 'latitude', 'name', 'description'));
    }

    public function repopulateRoute(Request $request) {
        $name = $request->old('name');
        $description = $request->old('description');
        $option = $request->old('transport');

        return view("trip/trip", compact('name', 'description', 'option'));
    }
}
