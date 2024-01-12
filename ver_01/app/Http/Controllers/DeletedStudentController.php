<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Skill;
use App\Models\Student;

class DeletedStudentController extends Controller
{
    //
    public function index(Request $request)
    {
        $skills = Skill::all();
        $type = $request->input('type');
        $value = $request->input('value');
        $selectVal = $request->input('skill_se');
        if ($type) {
            if ($type == 'phone') {
                $students = DB::table('students')->whereNotNull('deleted_at')
                    ->whereNotNull('deleted_at')->orWhereRaw("REPLACE(phone, '-', '') like '%" . str_replace('-', '', $value) . "%'")
                    ->paginate(5)->appends(['type' => $type, 'value' => $value]);
                if ($students->isEmpty()) {
                    return back()->withErrors('検索値が見つかりません。');
                } else {
                    return view('students/deleted_students-index', compact('students', 'selectVal', 'skills'))->with('i', (request()->input('page', 1) - 1) * 5);
                }
            } else if ($type == 'skill_se') {
                function hasSpecialCharacters($value)
                {
                    $pattern = '/[^\w\s]/';
                    return preg_match($pattern, $value);
                }
                if (!empty($selectVal)) {
                    $students = Student::where(function ($query) use ($selectVal) {
                        foreach ($selectVal as $val) {
                            if (hasSpecialCharacters($val)) {
                                $query->where('skill_se','like','%'.$val.'%');
                            } else {
                                $query->whereRaw("REPLACE(skill_se, '-', '') REGEXP '[[:<:]]" . $val . "(,|$)'");
                            }
                        }
                    })->paginate(5)->appends(['type' => $type, 'value' => $selectVal]);
                    if ($students->isEmpty()) {
                        return back()->withErrors('検索値が見つかりません。');
                    } else {
                        return view('students/students-index', compact('students', 'selectVal', 'skills'))->with('i', (request()->input('page', 1) - 1) * 5)
                            ->with('a', (request()->input('page', 1) - 1) * 5);
                    }
                } else {
                    $students = Student::paginate(5);
                    return view('students/students-index', compact('students', 'skills', 'selectVal'))->with('i', (request()->input('page', 1) - 1) * 5);
                }
            } else if ($type == 'name') {
                $students = DB::table('students')->whereNotNull('deleted_at')->where('name', 'like', '%' . $value . '%')->orWhere('name_kana', 'like', '%' . $value . '%')->paginate(5)->appends(['type' => $type, 'value' => $value]);
                if ($students->isEmpty()) {
                    return back()->withErrors('検索値が見つかりません。');
                } else {
                    return view('students/deleted_students-index', compact('students', 'selectVal', 'skills'))->with('i', (request()->input('page', 1) - 1) * 5);
                }
            } else {
                $students = DB::table('students')->whereNotNull('deleted_at')->where($type, 'like', '%' . $value . '%')->paginate(5)->appends(['type' => $type, 'value' => $value]);
                if ($students->isEmpty()) {
                    return back()->withErrors('検索値が見つかりません。');
                } else {
                    return view('students/deleted_students-index', compact('students', 'selectVal', 'skills'))->with('i', (request()->input('page', 1) - 1) * 5);
                }
            }
        } else {
            $students = DB::table('students')
                ->whereNotNull('deleted_at')->orderBy('deleted_at', 'desc')->paginate(5);
            return view('students/deleted_students-index', compact('students', 'selectVal', 'skills'))->with('i', (request()->input('page', 1) - 1) * 5);
        }
    }

    public function restore(string $id)
    {
        $student = Student::withTrashed()->find($id);
        $student->restore();
        return redirect()->route('students.index')->with('information', 'Successful!');
    }
}
