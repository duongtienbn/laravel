<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    //
    public function getStaff()
    {
        $staffs = Staff::all();
        return response()->json($staffs);
    }
    public function newStaff(Request $request)
    {
        $data = $request->input('newStaff');
        $staffs = new Staff();
        $staffs->name = $data;
        $staffs->save();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'staff' => $data,
        ]);
    }
    public function delStaff(Request $request)
    {
        $datas = $request->input('delStaff');
        if (isset($datas) && !empty($datas)) {
            foreach ($datas as $data) {
                $staffs = DB::table('staffs')->where('name', '=', $data);
                $staffs->delete();
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'staff' => $staffs,
        ]);
    }
}
