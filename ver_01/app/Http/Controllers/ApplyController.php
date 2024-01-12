<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apply;
use Illuminate\Support\Facades\DB;

class ApplyController extends Controller
{
    //
    public function getApply()
    {
        $applies = Apply::all();
        return response()->json($applies);
    }
    public function newApply(Request $request)
    {
        $data = $request->input('newApply');
        $apply = new Apply();
        $apply->name = $data;
        $apply->save();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'apply' => $data,
        ]);
    }
    public function delApply(Request $request)
    {
        $datas = $request->input('delApply');
        if (isset($datas) && !empty($datas)) {
            foreach ($datas as $data) {
                $applies = DB::table('apply_departments')->where('name', '=', $data);
                $applies->delete();
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'apply' => $applies,
        ]);
    }
}
