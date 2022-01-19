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
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
        ]);

        $user_data = request()->only('name', 'surname', 'email', 'password', 'avatar', 'description');
        $user_id = User::create($user_data);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storePublicly('avatars', 'public');
            $avatar = 'storage/' . $path;
            User::updateAvatar($user_id, $avatar);
        }

        $request->session()->regenerate();
        return redirect("login");
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::getByEmail($request->email);

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
            'name' => 'required|string|max:255',
            'surname' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()],
            'device_name' => 'required'
        ]);

        $data = request()->only('name', 'surname', 'email', 'password', 'avatar', 'description');
        $id = User::create($data);
        $user = User::find($id);

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
        $name = $user['name'];
        $surname = $user['surname'];
        $description = $user['description'];
        $avatar = $user['avatar'];

        return view("user/settings", compact('email', 'name', 'surname', 'description', 'avatar'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = Auth::user();
        $found_user = User::getByEmail($request->input('email'));

        if ($found_user && ($found_user['id'] != $user['id'])) {
            return redirect("settings");
        }

        $user_data = $request->only('name', 'surname', 'email', 'description');
        $user_data['id'] = $user['id'];

        if ($request->input('password') != "") {
            $request->validate([
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()],
            ]);
    
            $user_data['password'] = $request->input('password');
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storePublicly('avatars', 'public');
            $user_data['avatar'] = 'storage/' . $path;
        }

        User::updateById($user_data);
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
        $name = $request->old('name');
        $surname = $request->old('surname');

        return view("user/signup", compact('email', 'name', 'surname'));
    }
}
