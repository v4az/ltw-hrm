<?php

namespace App\Http\Controllers\Api\V1\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function dashboard(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employees(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function attendance(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function leaves(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function payroll(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function performance(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function recruitment(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function training(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function turnover(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function custom(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function export(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
