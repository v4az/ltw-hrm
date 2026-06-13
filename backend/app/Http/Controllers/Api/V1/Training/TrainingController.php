<?php

namespace App\Http\Controllers\Api\V1\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainingController extends Controller
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

    public function enroll(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function unenroll(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function participants(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function complete(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employeeHistory(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
