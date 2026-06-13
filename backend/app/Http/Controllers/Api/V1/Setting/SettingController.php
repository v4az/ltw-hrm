<?php

namespace App\Http\Controllers\Api\V1\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function update(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function company(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function updateCompany(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function workingHours(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function updateWorkingHours(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
