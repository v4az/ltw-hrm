<?php

namespace App\Http\Controllers\Api\V1\Skill;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function store(Request $request)
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

    public function employeeSkills(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function attachSkill(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }

    public function detachSkill(Request $request)
    {
        return response()->json(['todo' => __FUNCTION__]);
    }
}
