<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\UsersController;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('/trip', function () {
    return view('trip/trip');
})->name('trip');

Route::post('route', [RoutesController::class, 'create']);
Route::post('place', [RoutesController::class, 'addPlace']);

Route::get('route', [RoutesController::class, 'repopulate']);
Route::get('place', [RoutesController::class, 'repopulate']);

Route::get('trip/places', [RoutesController::class, 'showEmptyPlacesForm'])->name('trip/places');



// TODO: implement these routes 

Route::get('/login', function () {
    return view('user/login');
})->name('login');
Route::post('login', [UsersController::class, 'login']);

Route::get('/signup', function () {
    return view('user/signup');
})->name('signup');
Route::post('signup', [UsersController::class, 'signup']);

Route::get('/logout', function () {
    return view('welcome');
})->name('logout');

Route::get('/settings', function () {
    return view('welcome');
})->name('settings');