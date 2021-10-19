<?php

namespace App\Http\Controllers;

use App\Models\Route;
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
