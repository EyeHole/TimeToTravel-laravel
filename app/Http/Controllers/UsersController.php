<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{

    public function login(Request $request)
    {
        return response();
    }

    public function signup(Request $request)
    {
        return response();
    }

    public function get(Request $request)
    {

    }


    public function create(Request $request)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }

    public function delete(Request $request)
    {
        //
    }

    public function uploadAvatar(Request $request)
    {    
        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg|max:2048'
        ]);

        $path = $request->file('avatar')->storePublicly('avatars', 'public');
    
        // add path to user in database here
    
        return response()->json(['avatar' => $path]);
    }
}
