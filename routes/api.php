<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);

Route::get('/home', [HomeController::class, 'showTitels']);
Route::get('/home/season', [HomeController::class, 'showSeasonTitels']);

Route::get('/titel/{mal_id}', [ItemController::class, 'getTitel']);
Route::get('/titel/{mal_id}/episodes', [ItemController::class, 'getTitleEpisodes']);

Route::get('/title/{mal_id}/comments', [CommentController::class, 'showComments']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/{id}', [UserController::class, 'getUser']);
    Route::put('/user/{id}/update', [UserController::class, 'updateUser']);
    Route::delete('user/{id}', [UserController::class, 'destroyUser']);

    Route::get('/user/{id}/favorites', [FavoriteController::class, 'showFavorites']);
    Route::post('/favorites', [FavoriteController::class, 'storeFavorites']);
    Route::delete('/favorites/{mal_id}', [FavoriteController::class, 'destroyFavorites']);

    Route::post('/title/{mal_id}/comments', [CommentController::class, 'createComment']);
    Route::put('/title/{mal_id}/comments/{id}/update', [CommentController::class, 'updateComment']);
    Route::delete('/title/{mal_id}/comments/{id}', [CommentController::class, 'destroyComment']);
});
