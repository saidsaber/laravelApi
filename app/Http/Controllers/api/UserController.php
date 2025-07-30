<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Trait\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PDO;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(), 'validation error', 422);
        }
        $user = User::create($request->all());
        $token = $user->createToken('token-name')->plainTextToken;
        return ApiResponse::success(["token" => $token]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('token-name')->plainTextToken;
            return ApiResponse::success(["token" => $token]);
        } else {
            return ApiResponse::error("not found");
        }
    }

    public function logout(Request $request){
        // to delete the current token 
        $request->user()->currentAccessToken()->delete();
        // to delete all tokens 
        // $request->user()->tokens()->delete();
        return ApiResponse::success(['message' => 'Logged out successfully']);
    }
}
