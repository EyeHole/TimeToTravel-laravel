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

class UsersController extends Controller
{
    public function get(Request $request)
    {

    }


    public function create(Request $request)
    {
        $valid = validator($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()],
        ]);

        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }

        $data = request()->only('first_name', 'last_name', 'email', 'password', 'avatar');

        // adding avatar to public 
        // $avatar = data['avatar'] ? ... : 'none.jpg';
        $avatar = 'none.jpg';

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'is_author' => false,
            'date_of_birth' => '01-01-1900',
            'description' => '-',
            'avatar' => $avatar
        ]);

        return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
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
