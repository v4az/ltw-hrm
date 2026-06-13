<?php

namespace App\Http\Controllers\Api\V1\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function generate(Request $request)
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

    public function approve(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function disburse(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function payslips(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function summary(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
