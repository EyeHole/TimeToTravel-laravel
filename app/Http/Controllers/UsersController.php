<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{

    public function login(Request $request)
    {
        // TODO: implement
        return response();
    }

    public function signup(Request $request)
    {
        // TODO: implement
        return response();
    }


    public function update(Request $request)
    {
        // TODO: implement
        return response();
    }

    public function logout(Request $request)
    {
        // TODO: implement
        return response();
    }

    public function settings(Request $request)
    {
        // TODO: get current user and fill these params
    
        $name = 'Чье-то имя';
        $surname = 'Чья-то фамилия';
        $email = 'Почта';
        $bio = 'Био';

        return view("user/settings", compact('name', 'surname', 'email', 'bio'));
    }


   // old function - not used
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
