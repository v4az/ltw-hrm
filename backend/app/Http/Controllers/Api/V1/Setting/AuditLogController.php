<?php

namespace App\Http\Controllers\Api\V1\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function show(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function userTrail(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
