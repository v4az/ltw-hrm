<?php

namespace App\Http\Controllers\Api\V1\Performance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function store(\Illuminate\Http\Request $request)
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

    public function submit(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function approve(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employeeReviews(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function feedback(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
