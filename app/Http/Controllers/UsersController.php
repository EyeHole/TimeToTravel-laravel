<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
	{
	    return User::all();
	}

	public function show(User $user)
	{
	    return $user;
	}
}
