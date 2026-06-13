<?php

namespace App\Http\Controllers\Api\V1\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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

    public function uploadAvatar(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function documents(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function uploadDocument(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function deleteDocument(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function history(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function dependents(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function addDependent(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function updateDependent(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function deleteDependent(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function emergencyContacts(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function addEmergencyContact(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function terminate(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function rehire(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function import(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function export(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function search(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function orgChart(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
