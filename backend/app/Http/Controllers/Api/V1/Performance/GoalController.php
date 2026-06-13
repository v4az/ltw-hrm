<?php

namespace App\Http\Controllers\Api\V1\Performance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoalController extends Controller
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

    public function updateProgress(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
