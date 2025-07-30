<?php

use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('logout' , [UserController::class , 'logout']);
    Route::post('post/create' , [PostController::class , 'create']);
    Route::get('post' , [PostController::class , 'index']);
});

Route::post('/register' , [UserController::class , 'register']);
Route::post('/login' , [UserController::class , 'login'])->name('login');
