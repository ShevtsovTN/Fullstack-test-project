<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

Route::resource('comments', CommentController::class)->only([
    'store', 'update', 'destroy'
]);

Route::get('posts', [PostController::class, 'getPosts']);
Route::get('post/{post}', [PostController::class, 'getPost']);
