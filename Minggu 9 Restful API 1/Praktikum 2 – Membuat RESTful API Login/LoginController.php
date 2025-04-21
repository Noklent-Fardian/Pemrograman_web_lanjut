<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        //set validation
        $validation = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:6',
        ]);
        // if validation fail
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors(),
            ], 422);
        }
        $credentials = $request->only('username', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Username Atau Password Salah',
            ], 401);
        }

        //if success
        return response()->json([
            'status' => true,
            'message' => 'Login Berhasil',
            'user' => auth()->guard('api')->user(),
            'token' => $token,
            'success' => true,

            
        ], 200);
    }
}
