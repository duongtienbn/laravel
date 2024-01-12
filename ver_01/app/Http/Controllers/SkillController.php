<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;

class SkillController extends Controller
{
    //
    public function getSkill()
    {
        $skills = Skill::all();
        return response()->json($skills);
    }
    public function newSkill(Request $request)
    {
        $data = $request->input('newSkill');
        $skill = new Skill();
        $skill->name = $data;
        $skill->save();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'skill' => $data,
        ]);
    }
    public function delSkill(Request $request)
    {
        $data = $request->input('delSkill');
        $skills = DB::table('skills')->where('name', '=', $data);
        // $countries = Country::where('name', '=', $data);
        $skills->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'skill' => $skills,
        ]);
    }
}
