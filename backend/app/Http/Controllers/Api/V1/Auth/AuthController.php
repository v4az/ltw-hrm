<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function login(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function logout(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function refresh(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function forgotPassword(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function resetPassword(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function verifyEmail(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function resendVerification(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function changePassword(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function me(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function enable2fa(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function verify2fa(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function disable2fa(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
