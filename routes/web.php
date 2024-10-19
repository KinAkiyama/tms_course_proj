<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

// Route::get('/register', function () {
//     return view('welcome');
// });

// Route::get('/login', function () {
//     return view('welcome');
// });

// Route::get('/home', function () {
//     return view('welcome');
// });

// Route::get('/titel/{mal_id}', function () {
//     return view('welcome');
// });
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
