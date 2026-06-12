<?php

namespace App\Http\Controllers\Api\V1\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    public function show(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function download(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employeeList(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
