<?php

namespace App\Http\Controllers\Api\V1\Recruitment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
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

    public function publish(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function close(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function publicList(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
