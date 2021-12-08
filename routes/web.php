<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;

// Auth::routes();
Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::group(['middleware' => 'auth:web'], function () {    
    Route::group(['middleware' => 'author'], function () {  
        Route::get('/trip', function () {
            return view('trip/trip');
        })->name('trip');
        
        Route::post('route', [RoutesController::class, 'create']);
        Route::post('place', [RoutesController::class, 'addPlace']);

        Route::get('route', [RoutesController::class, 'repopulate']);
        Route::get('place', [RoutesController::class, 'repopulate']);

        Route::get('trip/places', [RoutesController::class, 'showEmptyPlacesForm'])->name('trip/places');
    });
});

Route::get('/login', function () {
    return view('user/login');
})->name('login');
Route::post('login', [AuthController::class, 'webLogin']);

Route::get('/signup', function () {
    return view('user/signup');
})->name('signup');
Route::post('signup', [AuthController::class, 'webSignup']);

// Route::get('/logout', function () {
//     return view('welcome');
// })->name('logout');
Route::get('logout', [AuthController::class, 'webSignOut'])->name('logout');

Route::get('/settings', [UsersController::class, 'settings'])->name('settings');
Route::post('settings', [UsersController::class, 'update']);
