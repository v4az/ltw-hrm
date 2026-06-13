<?php

namespace App\Http\Controllers\Api\V1\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeaveController extends Controller
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

    public function approve(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function reject(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employeeHistory(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function balance(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function calendar(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function pending(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
