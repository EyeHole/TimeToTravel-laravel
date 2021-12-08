<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function authorLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('email', 'password');
   
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }
  
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password_hash)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
    }

    public function webRegistration(Request $request)
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
        $user = $this->create($data);

        return redirect("/")->withSuccess('You have signed-up');
    }

    public function apiRegistration(Request $request)
    {  
        $valid = validator($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()],
            'device_name' => 'required'
        ]);

        if ($valid->fails()) {
            $jsonError=response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }

        $data = request()->only('first_name', 'last_name', 'email', 'password', 'avatar');
        $user = $this->create($data);

        return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
    }

    public function create(array $data)
    {
        // adding avatar to public 
        // $avatar = data['avatar'] ? ... : 'none.jpg';
        $avatar = 'none.jpg';

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'is_author' => false,
            'date_of_birth' => '01-01-1900',
            'description' => '-',
            'avatar' => $avatar
        ]);
    }  

    public function webSignOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('/');
    }
}
