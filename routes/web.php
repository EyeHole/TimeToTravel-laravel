<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('/trip', function () {
    return view('trip');
})->name('trip');

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