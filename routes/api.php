<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::get('posts', [PostsController::class, 'index']);
Route::get('posts/{post}', [PostsController::class, 'show']);
Route::get('categories', [CategoriesController::class, 'index']);


Route::middleware(['auth:sanctum'])->group(function () {
    // Route::resource('posts', PostsController::class);
    Route::delete('posts/{post}', [PostsController::class, 'destroy'])->middleware('check.admin.delete');
    Route::post('posts', [PostsController::class, 'store']);
    Route::patch('posts/{post}', [PostsController::class, 'update'])->middleware('check.post.author.or.admin');
});
