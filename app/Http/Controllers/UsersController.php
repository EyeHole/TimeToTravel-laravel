<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function login(Request $request)
    {
        //Moved to auth controller
    }

    public function signup(Request $request)
    {
        //Moved to auth controller
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
