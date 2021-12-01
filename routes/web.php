<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutesController;

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



// TODO: implement these routes 

Route::get('/signup', function () {
    return view('welcome');
})->name('signup');

Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::get('/signup', function () {
    return view('welcome');
})->name('signup');

Route::get('/logout', function () {
    return view('welcome');
})->name('logout');

Route::get('/settings', function () {
    return view('welcome');
})->name('settings');