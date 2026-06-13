<?php

namespace App\Http\Controllers\Api\V1\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    public function show(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function download(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function employeeList(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
