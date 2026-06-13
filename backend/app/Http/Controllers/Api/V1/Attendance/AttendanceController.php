<?php

namespace App\Http\Controllers\Api\V1\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function checkOut(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function index(Request $request)
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

    public function today(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employeeHistory(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function summary(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function manual(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function late(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function absent(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
