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
        
        Route::post('route', [RoutesController::class, 'create']);
        Route::post('sight', [RoutesController::class, 'addSight']);

        Route::get('route', [RoutesController::class, 'repopulateRoute'])->name('route');
        Route::get('sight', [RoutesController::class, 'repopulateSights'])->name('sight');
    });

    Route::get('settings', [AuthController::class, 'settings'])->name('settings');
    Route::post('settings', [AuthController::class, 'updateProfile']);
    Route::get('logout', [AuthController::class, 'webSignOut'])->name('logout');
});

Route::get('login', [AuthController::class, 'repopulateLogin'])->name('login');
Route::post('login', [AuthController::class, 'webLogin']);

Route::get('signup', [AuthController::class, 'repopulateSignup'])->name('signup');
Route::post('signup', [AuthController::class, 'webSignup']);

