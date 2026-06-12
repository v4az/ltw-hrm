<?php

namespace App\Http\Controllers\Api\V1\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContractController extends Controller
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

    public function sign(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function expiring(\Illuminate\Http\Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
