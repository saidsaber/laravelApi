<?php
namespace App\Http\Trait;

trait ApiResponse{

    public static function success($data = null , $massage = "success" , $code = 200){
        return response()->json([
            "success" => true,
            "massage" => $massage,
            "data" => $data,
            "errors" => null
        ], $code);
    }
    
    public static function error( $errors = [] , $massage = "success" , $code = 200){
        return response()->json([
            "success" => false,
            "massage" => $massage,
            "errors" => $errors
        ], $code);
    }
}