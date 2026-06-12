<?php

namespace App\Http\Controllers\Api\V1\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrainingController extends Controller
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

    public function enroll(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function unenroll(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function participants(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function complete(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employeeHistory(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
