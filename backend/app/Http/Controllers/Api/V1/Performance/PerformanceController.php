<?php

namespace App\Http\Controllers\Api\V1\Performance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerformanceController extends Controller
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

    public function submit(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function approve(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employeeReviews(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function feedback(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
