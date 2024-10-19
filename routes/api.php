<?php

use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class, 'showTitels']);
Route::get('/titel/{mal_id}', [ItemController::class, 'getTitel']);

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);