<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
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
            'password' => ['required', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/']
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return redirect("login")->withErrors(['email' => trans('auth.failed')]);
    }

    public function webSignup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
        ]);

        $data = request()->only('first_name', 'last_name', 'email', 'password', 'avatar', 'bio');
        $user = $this->create($data);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storePublicly('avatars', 'public');
            $user['avatar'] = 'storage/' . $path;
            $user->save();
        }

        $request->session()->regenerate();
        return redirect("login");
    }

    public function create(array $data)
    {
        if (!Arr::exists($data, 'avatar')) {
            $data['avatar'] = '';
        }

        if (!Arr::exists($data, 'bio')) {
            error_log("was nil");
            $data['bio'] = '';
        }

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_author' => false,
            'description' => $data['bio'],
            'avatar' => $data['avatar']
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

        if (!$user || !Hash::check($request->password, $user->password)) {
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

        $data = request()->only('first_name', 'last_name', 'email', 'password', 'avatar', 'bio');
        $user = $this->create($data);

        return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
    }

    public function webSignOut()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }

    public function settings(Request $request)
    {
        $user = Auth::user();
        $email = $user['email'];
        $name = $user['first_name'];
        $surname = $user['last_name'];
        $bio = $user['description'];
        $avatar = $user['avatar'];

        return view("user/settings", compact('email', 'name', 'surname', 'bio', 'avatar'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = Auth::user();

        $found_user = User::where([
            ['email', '=', $request->input('email')],
        ])->first();

        if ($found_user) {
            if ($found_user['id'] != $user['id']) {
                return redirect("settings");
            }
        }

        $user['first_name'] = $request->input('name');
        $user['last_name'] = $request->input('surname');
        $user['email'] = $request->input('email');
        $user['description'] = $request->input('bio');

        if ($request->input('password') != "") {
            $request->validate([
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()],
            ]);
            $user['password'] = $request->input('password');
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storePublicly('avatars', 'public');
            $user['avatar'] = 'storage/' . $path;
        }

        $user->save();
        error_log($user);

        return redirect("settings");
    }

    public function repopulateLogin(Request $request)
    {
        $email = $request->old('email');
        return view("user/login", compact('email'));
    }

    public function repopulateSignup(Request $request)
    {
        $email = $request->old('email');
        $first_name = $request->old('first_name');
        $last_name = $request->old('last_name');

        return view("user/signup", compact('email', 'first_name', 'last_name'));
    }
}
