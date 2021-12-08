<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'route'], function () {
        Route::get('info/{id}', [RoutesController::class, 'info']);
        Route::get('points/{id}', [RoutesController::class, 'points']);
        Route::post('city/{limit}/{skip}', [RoutesController::class, 'city']);
    });
    
    Route::post('upload/avatar', [UsersController::class, 'uploadAvatar']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('signup', [AuthController::class, 'apiSignup']);
    Route::post('login', [AuthController::class, 'apiLogin']);
});
