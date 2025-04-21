<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            //remove token from blacklist
            $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
            if ($removeToken) {
                return response()->json([
                    'status' => true,
                    'message' => 'Logout Berhasil',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Logout Gagal',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Logout Gagal: ' . $e->getMessage(),
            ], 500);
        }
    }
}
