<?php

namespace App\Http\Controllers\Api\V1\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function checkOut(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function index(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function show(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function update(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function destroy(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function today(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employeeHistory(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function summary(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function manual(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function late(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function absent(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
