<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function store(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function show(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function update(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function destroy(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function activate(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function deactivate(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function resetPassword(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function sessions(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function revokeSession(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
