<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;

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

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/posts', [PostController::class, 'index']);

// Protected routes (require authentication)
Route::middleware('auth:api', 'throttle:60,1')->group(function () {
    // User-related routes
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Post-related routes
    Route::prefix('/posts')->group(function () {
        Route::post('/', [PostController::class, 'store']);
        Route::delete('/{post}', [PostController::class, 'destroy']);
    });

    // Like-related routes
    Route::post('/posts/{post}/like', [LikeController::class, 'toggleLike']);  // Like or unlike a post
});
