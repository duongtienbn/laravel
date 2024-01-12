<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    //
    public function getDpmt() {
        $departments = Department::all();
        return response()->json($departments);
    }
    public function newDpmt(Request $request) {
        $data = $request->input('newDepartment');
        $departments = new Department();
        $departments->name = $data;
        $departments->save();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'department' => $data,
        ]);
    }
    public function delDpmt(Request $request) {
        $data = $request->input('delDepartment');
        $departments = DB::table('departments')->where('name', '=', $data);
        $departments->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'department' => $departments,
        ]);
    }
}
