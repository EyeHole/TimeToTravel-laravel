<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Sight;
use Illuminate\Http\Request;

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

    public function create(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
        ]);
    
        $route = new Route();
        $route['name'] = $request->input('name');
        $route['description'] = $request->input('description');
        $route['transport'] = $request->input('transport');

        //get user id and default city here
        $route['user_id'] = 1;
        $route['city_id'] = 1;
        
        $route->save();

        error_log($route);

        $id = $route['id'];
        $order = 1;
        $length = 1;
        $longitude = "";
        $latitude = "";
        $name = "";
        $description = "";

        return view("trip/places", compact('id', 'order', 'length', 'longitude', 'latitude', 'name', 'description'));
    }

    public function showPlace(int $id, int $order, int $length)
    {
        $sight = Sight::where([
            ['route_id', '=', $id],
            ['priority', '=', $order],
        ])->first();
        if ($sight == null) {
            $longitude = "";
            $latitude = "";
            $name = "";
            $description = "";
        } else {
            $longitude = $sight['longitude'];
            $latitude = $sight['latitude'];
            $name = $sight['name'];
            $description = $sight['description'];
        }

        return view("trip/places", compact('id', 'order', 'length', 'longitude', 'latitude', 'name', 'description'));
    }

    public function addPlace(Request $request)
    {
        $trip_id = $request->input('trip_id');
        $order = $request->input('order');
        $length = $request->input('length');
    
        if ($request->input('action') == 'prev') {
                return $this->showPlace($trip_id, $order-1, $length);
        } 
        
        if ($request->input('action') ==  'next') {
            return $this->showPlace($trip_id, $order+1, $length);
        }

        $request->validate([
            'name' => 'required|max:255',
            'latitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'], 
            'longitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
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

        $place->save();
        
        if ($request->input('action') == 'new') {
            return $this->showPlace($trip_id, $length+1, $length+1);
        }
        return $this->showTripInfo($trip_id);
    }

    public function showTripInfo(int $trip_id)
    {
        $route = Route::find($trip_id);
        $name = $route['name'];
        $description = $route['description'];
        $option = $route['transport'];
        $length = Sight::where([['route_id','=', $trip_id]])->count();
    
        return view("trip/overview", compact('length', 'name', 'description', 'option'));
    }

    public function repopulate(Request $request) {
        $id = $request->old('trip_id');
        $order = $request->old('order');
        $length = $request->old('length');
        $longitude = $request->old('longitude');
        $latitude = $request->old('latitude');
        $name = $request->old('name');
        $description = $request->old('description');

        return view("trip/places", compact('id', 'order', 'length', 'longitude', 'latitude', 'name', 'description'));
    }
}
