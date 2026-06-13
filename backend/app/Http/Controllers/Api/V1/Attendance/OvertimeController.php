<?php

namespace App\Http\Controllers\Api\V1\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    public function submit(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function index(Request $request)
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
}
