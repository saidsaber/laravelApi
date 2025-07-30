<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Trait\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Validated;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
         return ApiResponse::success(['data' => $posts]);
    }
    public function create(Request $request){
        $validation = $request->validate([
            'title' => "required|min:5",
            'content' => "required|max:255"
        ]);
        $validation['user_id'] = Auth::id();

        Post::create($validation);
        return ApiResponse::success(['data' => $validation]);
    }
}
