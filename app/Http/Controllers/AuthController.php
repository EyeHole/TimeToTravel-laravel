<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function webLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'min:8','regex:/[a-zA-Z]/', 'regex:/[0-9]/']
        ]);
        
        $credentials = $request->only('email', 'password');
   
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function webSignup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
        ]);

        $data = request()->only('first_name', 'last_name', 'email', 'password', 'avatar');
        $user = $this->create($data);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storePublicly('avatars', 'public');
            $user['avatar'] = $path;
            $user->save();
        }

        $request->session()->regenerate();
        return redirect("/")->withSuccess('You have signed-up');
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
            'password' => Hash::make($data['password']),
            'is_author' => false,
            'date_of_birth' => '01-01-1900',
            'description' => '-',
            'avatar' => $avatar
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
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
    }

    public function apiSignup(Request $request)
    {  
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()],
            'device_name' => 'required'
        ]);

        $data = request()->only('first_name', 'last_name', 'email', 'password', 'avatar');
        $user = $this->create($data);

        return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
    } 

    public function webSignOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('/');
    }

    public function repopulateLogin(Request $request) {
        $email = $request->old('email');
        return view("user/login", compact('email'));
    }

    public function repopulateSignup(Request $request) {
        $email = $request->old('email');
        $first_name = $request->old('first_name');
        $last_name = $request->old('last_name');

        return view("user/signup", compact('email', 'first_name', 'last_name'));
    }
}
