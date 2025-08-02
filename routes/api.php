<?php

use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\PostCondition;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('logout' , [UserController::class , 'logout']);
    Route::post('post/create' , [PostController::class , 'create']);
    Route::get('post' , [PostController::class , 'index']);
    Route::get('post/{post}' , [PostController::class , 'getPost']);
    Route::delete("post/{post}" , [PostController::class , 'delete']);
    Route::put("post/update/{post}" , [PostController::class , 'update']);
});

Route::post('/register' , [UserController::class , 'register']);
Route::post('/login' , [UserController::class , 'login'])->name('login');
