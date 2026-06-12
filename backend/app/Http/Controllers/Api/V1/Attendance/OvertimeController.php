<?php

namespace App\Http\Controllers\Api\V1\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function submit(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function index(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function approve(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function reject(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
