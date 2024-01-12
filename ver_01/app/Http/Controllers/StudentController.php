<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Skill;
use App\Models\Country;
use App\Models\Staff;
use App\Models\Apply;
use App\Models\Department;
use App\Models\Place;
use Illuminate\Support\Facades\DB;
//ティン追加
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;

use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

//テイエン　追加
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

//saveではなく、downloadのために使います
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $skills = Skill::all();
        $selectVal = $request->input('skill_se');
        $searchName = $request->input('searchName');

        //国で検索
        $countries = Country::all();
        $country_value = $request->input('country_value');

        // 面接日で検索
        $selectedDateType = $request->input('date_type');
        $start_day = $request->input('start_day');
        $end_day = $request->input('end_day');

        $skills = Skill::all();
        $countries = Country::all();
        $staffs = Staff::all();
        $departments = Department::all();
        $applies = Apply::all();
        $places = Place::all();
        $type = $request->input('type');
        $value = $request->input('value');
        if ($type) {
            if ($type == 'phone') {
                $students = Student::orWhereRaw("REPLACE(phone, '-', '') like '%" . str_replace('-', '', $value) . "%'")
                    ->paginate(5)->appends(['type' => $type, 'value' => $value]);
                if ($students->isEmpty()) {
                    return back()->withErrors('検索値が見つかりません。');
                } else {
                    return view('students/students-index', compact('students', 'selectVal', 'skills', 'countries', 'staffs', 'departments', 'applies', 'places'))
                        ->with('index', ($students->currentPage() - 1) * $students->perPage() + 1);
                }
                //スキル検索
            } else if ($type == 'skill_se') {
                $skills = Skill::all();
                if (!empty($searchName)) {
                    $arrSearchName = explode(", ", $searchName);
                    $arrYears = ['趣味or1年未満', '1年以上', '2年以上', '3年以上', '5年以上', '0'];
                    $students = Student::where(function ($query) use ($arrSearchName, $arrYears) {
                        foreach ($arrSearchName as $val) {
                            $arrVal = explode('&', $val);
                            if ($arrVal[1] === '趣味or1年未満') {
                                for ($i = 0; $i < 6; $i++) {
                                    $newVal = $arrVal[0] . $arrYears[$i];
                                    $query->orWhereRaw("REPLACE(skill_se, '&', '') LIKE '%" . $newVal . "%'");
                                }
                            }
                            if ($arrVal[1] === '1年以上') {
                                for ($i = 1; $i < 6; $i++) {
                                    $newVal = $arrVal[0] . $arrYears[$i];
                                    $query->orWhereRaw("REPLACE(skill_se, '&', '') LIKE '%" . $newVal . "%'");
                                }
                            }
                            if ($arrVal[1] === '2年以上') {
                                for ($i = 2; $i < 6; $i++) {
                                    $newVal = $arrVal[0] . $arrYears[$i];
                                    $query->orWhereRaw("REPLACE(skill_se, '&', '') LIKE '%" . $newVal . "%'");
                                }
                            }
                            if ($arrVal[1] === '3年以上') {
                                for ($i = 3; $i < 6; $i++) {
                                    $newVal = $arrVal[0] . $arrYears[$i];
                                    $query->orWhereRaw("REPLACE(skill_se, '&', '') LIKE '%" . $newVal . "%'");
                                }
                            }
                            if ($arrVal[1] === '5年以上') {
                                for ($i = 4; $i < 6; $i++) {
                                    $newVal = $arrVal[0] . $arrYears[$i];
                                    $query->orWhereRaw("REPLACE(skill_se, '&', '') LIKE '%" . $newVal . "%'");
                                }
                            }
                        }
                    })->paginate(5)->appends(['type' => $type, 'searchName' => $searchName]);
                    if ($students->count() === 0) {
                        return back()->withErrors('検索値が見つかりません。');
                    } else {
                        return view('students/students-index', compact('skills', 'searchName', 'countries', 'students'))
                            ->with('index', ($students->currentPage() - 1) * $students->perPage() + 1);
                    }
                } else {
                    $students = Student::paginate(5);
                    return view('students/students-index', compact('skills', 'searchName', 'countries', 'students'))
                        ->with('index', ($students->currentPage() - 1) * $students->perPage() + 1);
                }
                //国検索
            } else if ($type == 'country') {
                if (!empty($country_value)) {
                    $students = Student::whereIn('country', $country_value)
                        ->paginate(5)
                        ->appends(['type' => $type, 'country_value' => $country_value]);

                    if ($students->isEmpty()) {
                        return back()->withErrors('検索値が見つかりません。');
                    } else {
                        return view('students/students-index', compact('students', 'skills', 'selectVal', 'countries', 'country_value'))
                            ->with('index', ($students->currentPage() - 1) * $students->perPage() + 1);
                    }
                } else {
                    return back()->withError('country');
                }
                // 実行日
            } else if ($type == 'interview_date') {
                $students = Student::whereBetween($selectedDateType, [$start_day, $end_day])->paginate(5)->appends(['type' => $type, 'start_day' => $start_day, 'end_day' => $end_day, 'date_type' => $selectedDateType]);
                if ($students->isEmpty()) {
                    return back()->withErrors('検索値が見つかりません。');
                } else {
                    return view('students/students-index', compact('students', 'skills', 'countries', 'start_day', 'end_day', 'selectedDateType'))
                        ->with('index', ($students->currentPage() - 1) * $students->perPage() + 1);
                }
                //name
            } else if ($type == 'name') {
                $students = Student::where('name', 'like', '%' . $value . '%')->orWhere('name_kana', 'like', '%' . $value . '%')->paginate(5)->appends(['type' => $type, 'value' => $value]);
                if ($students->isEmpty()) {
                    return back()->withErrors('検索値が見つかりません。');
                } else {
                    return view('students/students-index', compact('students', 'selectVal', 'skills', 'countries', 'staffs', 'departments', 'applies', 'places', 'start_day', 'end_day', 'selectedDateType'))
                        ->with('index', ($students->currentPage() - 1) * $students->perPage() + 1);
                }
                //ageから検索
            } else if ($type == 'age') {
                $value = $request->input('value');
                if ($value >= 10 && $value <= 100) {
                    $students = Student::where('age', '=', $value)
                        ->paginate(5)
                        ->appends(['type' => $type, 'value' => $value]);
                } else {
                    $minAge = intval($value) * 10;
                    $maxAge = $minAge + 9;
                    $students = Student::whereBetween('age', [$minAge, $maxAge])
                        ->paginate(5)
                        ->appends(['type' => $type, 'value' => $value]);
                }
                if ($students->isEmpty()) {
                    return back()->withErrors('検索値が見つかりません。');
                } else {
                    return view('students/students-index', compact('students', 'selectVal', 'skills', 'countries', 'staffs', 'departments', 'applies', 'places', 'start_day', 'end_day', 'selectedDateType'))
                    ->with('index', ($students->currentPage() - 1) * $students->perPage() + 1);
                }
            } else {
                $students = Student::where($type, 'like', '%' . $value . '%')->paginate(5)->appends(['type' => $type, 'value' => $value]);
                if ($students->isEmpty()) {
                    return back()->withErrors('検索値が見つかりません。');
                } else {
                    return view('students/students-index', compact('students', 'selectVal', 'skills', 'countries', 'staffs', 'departments', 'applies', 'places', 'start_day', 'end_day', 'selectedDateType'))
                        ->with('index', ($students->currentPage() - 1) * $students->perPage() + 1);
                }
            }
        } else {

            $students = Student::paginate(5);
            return view('students/students-index', compact('students', 'skills', 'selectVal', 'countries', 'staffs', 'departments', 'applies', 'places'))
                ->with('index', ($students->currentPage() - 1) * $students->perPage() + 1);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        $skills = Skill::all();
        $staffs = Staff::all();
        $applies = Apply::all();
        $departments = Department::all();
        $places = Place::all();
        return view('students/students-create', compact(
            'skills',
            'countries',
            'staffs',
            'applies',
            'departments',
            'places'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'name_kana' => ['nullable', 'regex:/^[\p{Script=Katakana}\p{Zs}ー　]+$/u'],
                'phone' => 'nullable|unique:students,phone|regex:/^\d+(?:-\d+)*$/',
                'email' => 'nullable|unique:students,email|email',


            ],
            [
                'name.required' => '名前を入力してください。！',
                'name_kana.regex' => '名前をカタカナで入力してください。!',
                'phone.regex' => 'これは電話番号ではないです。!',
                'phone.unique' => 'この電話番号は、以前に入力した電話番号と似ています。!',
                'email.email' => 'これはメールアドレスではないです。!',
                'email.unique' => 'このメールアドレス は、以前に入力したメール と似ています。!',
            ]
        );

        if (!$validator->fails()) {
            $graduate_4 = $request->has('graduate_4') ? 1 : 0;
            $graduate_2 = $request->has('graduate_2') ? 1 : 0;
            $data = $request->all();
            $data['graduate_4'] = $graduate_4;
            $data['graduate_2'] = $graduate_2;

            $first_interv_staff = $request->input('first_interv_staff');
            if (isset($first_interv_staff) && !empty($first_interv_staff)) {
                $first_interv_staff_seStr = implode(',', $first_interv_staff);
                $data['first_interv_staff'] = $first_interv_staff_seStr;
            }
            $sec_interv_staff = $request->input('sec_interv_staff');
            if (isset($sec_interv_staff) && !empty($sec_interv_staff)) {
                $sec_interv_staff_seStr = implode(',', $sec_interv_staff);
                $data['sec_interv_staff'] = $sec_interv_staff_seStr;
            }
            $apply_department = $request->input('apply_department');
            if (isset($apply_department) && !empty($apply_department)) {
                $apply_department_seStr = implode(',', $apply_department);
                $data['apply_department'] = $apply_department_seStr;
            }
            $working_place = $request->input('working_place');
            if (isset($working_place) && !empty($working_place)) {
                $working_place_seStr = implode(',', $working_place);
                $data['working_place'] = $working_place_seStr;
            }
            if (!empty($data['sex'])) {
                if ($data['sex'] == '男') {
                    $data['sex'] = 1;
                } elseif ($data['sex'] == '女') {
                    $data['sex'] = 2;
                } else {
                    $data['sex'] = 0;
                }
            }
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['birthday']) && $data['birthday'] != null) {
                $data['birthday'] = str_replace(["年", "月", "日"], "-", $data['birthday']);
            }
            $student = Student::create($data);
            if ($request->input('source') === 'pdf') {
                $studentId = $student->id;
                if (!Storage::exists('user_files/' . $studentId)) {
                    // create user directory
                    Storage::makeDirectory('user_files/' . $studentId);
                }
                $userpdf = storage_path('user.pdf');
                $userpdf_cp = storage_path('app/user_files/' . $studentId . '/' . $request->input('fileName'));
                File::copy($userpdf, $userpdf_cp);
            }
            return redirect()->route('students.index')->with('information', 'Successful!');
        } else {
            $fileName = $request->input('fileName');
            if ($request->input('source') === 'pdf') {
                return redirect()->route('student.pdf', compact('fileName'))->withErrors($validator)->withInput();
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $student = DB::table('students')->where('id', $id)->get()->first();
        $studentArray = $student ? (array) $student : [];
        $arraySkills = Arr::only($studentArray, ['skill_jlpt', 'skill_hearing', 'skill_speaking', 'skill_reading']);
        // $student = Student::find($id);
        return view('students/students-show', compact('student', 'arraySkills'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::find($id);
        $countries = Country::all();
        $skills = Skill::all();
        $staffs = Staff::all();
        $applies = Apply::all();
        $departments = Department::all();
        $places = Place::all();
        $skill_se_string = $student->skill_se;
        $first_interv_staff_string = $student->first_interv_staff;
        $arrayFirst_interv_staff = explode(",", $first_interv_staff_string);
        $sec_interv_staff_string = $student->sec_interv_staff;
        $arraySec_interv_staff = explode(",", $sec_interv_staff_string);
        $apply_department_string = $student->apply_department;
        $arrayApply_department = explode(",", $apply_department_string);
        $working_place_string = $student->working_place;
        $arrayWorking_place = explode(",", $working_place_string);
        $student['first_interv_staff'] = $arrayFirst_interv_staff;
        $student['sec_interv_staff'] = $arraySec_interv_staff;
        $student['apply_department'] = $arrayApply_department;
        $student['working_place'] = $arrayWorking_place;
        return view('students/students-edit', compact(
            'student',
            'skills',
            'countries',
            'staffs',
            'applies',
            'departments',
            'places'
        ));;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'name_kana' => ['nullable', 'regex:/^[\p{Script=Katakana}\p{Zs}ー　]+$/u'],
            'phone' => [
                'nullable',
                'regex:/^\d+(?:-\d+)*$/',
                Rule::unique('students')->ignore($id),
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('students')->ignore($id),
            ],
        ], [
            'name.required' => '名前を入力してください。！',
            'name_kana.regex' => '名前をカタカナで入力してください。!',
            'phone.regex' => 'これは電話番号ではないです。!',
            'phone.unique' => 'この電話番号は、以前に入力した電話番号と似ています。!',
            'email.email' => 'これはメールアドレスではないです。!',
            'email.unique' => 'このメールアドレスは、以前に入力したメールと似ています。!',
        ]);
        $data = $request->all();
        $student = Student::find($id);
        $graduate_4 = $request->has('graduate_4') ? 1 : 0;
        $graduate_2 = $request->has('graduate_2') ? 1 : 0;
        $data['graduate_4'] = $graduate_4;
        $data['graduate_2'] = $graduate_2;
        $first_interv_staff = $request->input('first_interv_staff');
        if (isset($first_interv_staff) && !empty($first_interv_staff)) {
            $first_interv_staff_seStr = implode(',', $first_interv_staff);
            $data['first_interv_staff'] = $first_interv_staff_seStr;
        } else {
            $data['first_interv_staff'] = null;
        }
        $sec_interv_staff = $request->input('sec_interv_staff');
        if (isset($sec_interv_staff) && !empty($sec_interv_staff)) {
            $sec_interv_staff_seStr = implode(',', $sec_interv_staff);
            $data['sec_interv_staff'] = $sec_interv_staff_seStr;
        } else {
            $data['sec_interv_staff'] = null;
        }
        $apply_department = $request->input('apply_department');
        if (isset($apply_department) && !empty($apply_department)) {
            $apply_department_seStr = implode(',', $apply_department);
            $data['apply_department'] = $apply_department_seStr;
        } else {
            $data['apply_department'] = null;
        }
        $working_place = $request->input('working_place');
        if (isset($working_place) && !empty($working_place)) {
            $working_place_seStr = implode(',', $working_place);
            $data['working_place'] = $working_place_seStr;
        } else {
            $data['working_place'] = null;
        }
        $student->update($data);
        return redirect()->route('students.index')->with('information', 'Update Successful!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->input('confirmDel');
        $student = Student::find($id);
        $student->delete();
        return back()->with('information', 'Delete Successful!');
    }

    public function export()
    {
        //09_import_Thinh のpublicのtest.xlsx
        $spreadsheet = IOFactory::load(public_path('template.xlsx'));
        // アクティブなワークシートを取得する
        $worksheet = $spreadsheet->getActiveSheet();
        // 新しいデータの開始行を設定します
        $startRow = 6;
        // エクスポート クラスの新しいインスタンスを作成する
        $export = new StudentsExport;
        // エクスポート クラスからデータを取得する
        $data = $export->collection()->toArray();
        // データをループしてワークシートに挿入する
        foreach ($data as $row) {
            $colIndex = 2;
            foreach ($row as $key => $value) {
                $cell = $worksheet->getCellByColumnAndRow($colIndex, $startRow);
                if ($key == 'age') {
                    if (isset($row['birthday'])) {
                        $cell->setValue('=IF(F' . $startRow . ' <> "", DATEDIF(F' . $startRow . ', TODAY(), "Y"), "")');
                    } else {
                        $cell->setValue($value);
                    }
                } else {
                    $cell->setValue($value);
                }
                if ($key == 'sex') {
                    if ($value == 1) {
                        $cell->setValue('男');
                    } elseif ($value == 2) {
                        $cell->setValue('女');
                    } else {
                        $cell->setValue('');
                    }
                }
                if ($key == 'graduate_4' || $key == 'graduate_2') {
                    if ($value == 0) {
                        $cell->setValue('');
                    } elseif ($value == 1) {
                        $cell->setValue('〇');
                    }
                }
                if ($key == 'skill_jlpt' || $key == 'skill_hearing' || $key == 'skill_speaking' || $key == 'skill_reading') {
                    if ($value == 6) {
                        $cell->setValue('未取得');
                    } elseif ($value != "") {
                        $cell->setValue('N' . $value);
                    }
                }

                if ($key == 'first_interv_result' || $key == 'sec_interv_result' || $key == 'intern_result') {
                    if ($value === 0) {
                        $cell->setValue('未定');
                    } elseif ($value == 1) {
                        $cell->setValue('合格');
                    } elseif ($value == 2) {
                        $cell->setValue('不合格');
                    } else {
                        $cell->setValue('');
                    }
                }

                if ($key == 'skill_se') {
                    if (!empty($value)) {
                        $arrValue = explode(', ', $value);
                        $formatedArr = [];
                        foreach ($arrValue as $val) {
                            $newValArr = explode('&', $val);
                            if ($newValArr[1] == '趣味or1年未満') {
                                $newValArr[1] = 1;
                                $formatedVal = $newValArr[0] . '&' . $newValArr[1];
                                array_push($formatedArr, $formatedVal);
                            } elseif ($newValArr[1] == '1年以上') {
                                $newValArr[1] = 2;
                                $formatedVal = $newValArr[0] . '&' . $newValArr[1];
                                array_push($formatedArr, $formatedVal);
                            } elseif ($newValArr[1] == '2年以上') {
                                $newValArr[1] = 3;
                                $formatedVal = $newValArr[0] . '&' . $newValArr[1];
                                array_push($formatedArr, $formatedVal);
                            } elseif ($newValArr[1] == '3年以上') {
                                $newValArr[1] = 4;
                                $formatedVal = $newValArr[0] . '&' . $newValArr[1];
                                array_push($formatedArr, $formatedVal);
                            } elseif ($newValArr[1] == '5年以上') {
                                $newValArr[1] = 5;
                                $formatedVal = $newValArr[0] . '&' . $newValArr[1];
                                array_push($formatedArr, $formatedVal);
                            } else {
                                $formatedVal = $newValArr[0] . '&' . $newValArr[1];
                                array_push($formatedArr, $formatedVal);
                            }
                        }
                        $formatedSkill_se = implode(", ", $formatedArr);
                        $cell->setValue($formatedSkill_se);
                    }
                }

                // セルのスタイルを取得する
                $style = $worksheet->getStyleByColumnAndRow($colIndex, $startRow);
                // セルのすべての辺に境界線のスタイルを設定する
                $style->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $colIndex++;
            }
            $startRow++;
        }

        // 変更した Excel ファイルを保存する
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        //09_import_Thinh のpublicのnewExcelに返す
        $writer->save('newExcel.xlsx');

        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="newExcel.xlsx"',
        ];

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, $headers);

        return $response;
    }

    public function import(Request $request)
    {
        if (!$request->hasFile('file')) {
            return back()->withErrors(['message' => 'ファイルを選択してください。']);
        }
        // deletedした情報を保存する
        $students = DB::table('students')->whereNotNull('deleted_at')->orderBy('deleted_at')->get();
        // テーブルを更新する
        DB::table('students')->truncate();
        //インポートする
        Excel::import(new StudentsImport, request()->file('file'));
        //インポートした後、削除した情報はテーブルの最後に入れる
        $lastId = DB::table('students')->max('id');
        return redirect()->route('students.index')->with('information', 'Successful!');
    }

    public function pdf(Request $request)
    {
        $file = $request->file;
        $pdfParser = new Parser();
        $data = ['name', 'name_kana', 'email', 'country', 'phone', 'birthday', 'sex'];
        $namekataAssigned = false;
        if ($request->hasFile('file')) {
            $request->validate([
                'file' => 'required|mimes:pdf',
            ]);
            $fileName = $request->file('file')->getClientOriginalName();
            $pdf = $pdfParser->parseFile($file->path());
            $content = $pdf->getText();
            $content = str_replace("\t", "", $content);
            $content = preg_replace('/ +/', ' ', $content);
            $encodedContent = mb_convert_encoding($content, 'UTF-8');
            $lines = explode("\n", $encodedContent);

            $textPath = storage_path('\text.txt');
            file_put_contents($textPath, $encodedContent);

            $pdfPath = storage_path('user.pdf');
            file_put_contents($pdfPath, file_get_contents($file->path()));
        } else {
            $fileName = $request->input('fileName');
            $content = Storage::get('/text.txt');
            $text = file_get_contents(storage_path('/text.txt' . $content));
            $lines = explode("\n", $text);
        }

        foreach ($lines as $line) {
            if (strpos($line, '氏 名') !== false) {
                $data['name'] = trim(str_replace('氏 名', '', $line)); // Nhặt giá trị sau từ "Name"
            }
            if (strpos($line, 'ふりがな') !== false && !$namekataAssigned) {
                $data['name_kana'] = trim(str_replace('ふりがな', '', $line));
                $namekataAssigned = true;
            }
            $pattern = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}\b/';
            if (preg_match($pattern, $line, $matches)) {
                $data['email'] = $matches[0];
            }
            if (strpos($line, '国 籍') !== false) {
                $data['country'] = trim(str_replace('国 籍', '', $line));
            }
            if (strpos($line, '男') !== false || strpos($line, '女') !== false) {
                $data['sex'] = preg_replace('/[^男|女]/u', '', $line);
            }
            if (strpos($line, '生年月日') !== false) {
                $start = strpos($line, '生年月日') + mb_strlen('生年月日', 'UTF-8');
                $data['birthday'] = trim(mb_substr($line, $start, 12, 'UTF-8'));
            }
            if (strpos($line, '電話番号') !== false) {
                $data['phone'] = trim(str_replace('電話番号', '', $line));
            }
        }
        return view('students.pdf', compact('data', 'fileName'));
    }
}
