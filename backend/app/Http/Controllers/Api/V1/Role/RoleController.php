<?php

namespace App\Http\Controllers\Api\V1\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
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

    public function permissions(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function attachPermissions(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function detachPermission(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function assign(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
