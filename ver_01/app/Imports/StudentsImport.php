<?php

namespace App\Imports;

use App\Models\Student;
//以下のuseを追加します。
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

class StudentsImport implements ToCollection, WithHeadingRow, WithValidation, WithCalculatedFormulas //追加したやつをここに書きます
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    /** public function model(array $row) でした。
     *
     *インポートする前にチェックするためにpublic function collection(Collection $rows)を使います
     *
     *
     */
    //日にちは 「Y-m-d」にするfunction
    public function transformDate($value, $format = 'Y/m/d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    public function collection(Collection $rows)
    {
        $errors_array = [];
        $m = 6;
        // 6行目からインポートする
        $datas = $rows->slice(4);
        foreach ($datas as $row) {
            $value1 = $row[20];
            $value2 = $row[21];
            $value3 = $row[22];
            $value4 = $row[23];

            if ($row[4] == '男') {
                $row[4] = 1;
            } elseif ($row[4] == '女') {
                $row[4] = 2;
            } else {
                $row[4] = 0;
            }
            //
            if ($row[25] == '〇') {
                $row[25] = 1;
            } elseif ($row[25] == '') {
                $row[25] = 0;
            }
            //
            if ($row[26] == '〇') {
                $row[26] = 1;
            } elseif ($row[26] == '') {
                $row[26] = 0;
            }
            //
            if ($row[10] == '合格') {
                $row[10] = 1;
            } elseif ($row[10] == '不合格') {
                $row[10] = 2;
            } elseif ($row[10] == '未定') {
                $row[10] = 0;
            } else {
                $row[10] = null;
            }

            if ($row[13] == '合格') {
                $row[13] = 1;
            } elseif ($row[13] == '不合格') {
                $row[13] = 2;
            } elseif ($row[13] == '未定') {
                $row[13] = 0;
            } else {
                $row[13] = null;
            }

            if ($row[16] == '合格') {
                $row[16] = 1;
            } elseif ($row[16] == '不合格') {
                $row[16] = 2;
            } elseif ($row[16] == '未定') {
                $row[16] = 0;
            } else {
                $row[16] = null;
            }
            //
            if (is_int($row[5])) {
                $row5 = $this->transformDate($row[5]);
            } else {
                $row5 = $row[5];
            }

            if (empty($row[6])) {
                $row[6] = null;
            }

            if (is_int($row[8])) {
                $row[8] = $this->transformDate($row[8]);
            }

            if (is_int($row[11])) {
                $row[11] = $this->transformDate($row[11]);
            }

            if (is_int($row[14])) {
                $row[14] = $this->transformDate($row[14]);
            }

            if (is_int($row[17])) {
                $row[17] = $this->transformDate($row[17]);
            }
            //
            switch ($value1) {
                case 'N5':
                    $value1 = '5';
                    break;
                case 'N4':
                    $value1 = '4';
                    break;
                case 'N3':
                    $value1 = '3';
                    break;
                case 'N2':
                    $value1 = '2';
                    break;
                case 'N1':
                    $value1 = '1';
                    break;
                case '未取得':
                    $value1 = '6';
                    break;
            }

            switch ($value2) {
                case 'N5':
                    $value2 = '5';
                    break;
                case 'N4':
                    $value2 = '4';
                    break;
                case 'N3':
                    $value2 = '3';
                    break;
                case 'N2':
                    $value2 = '2';
                    break;
                case 'N1':
                    $value2 = '1';
                    break;
            }

            switch ($value3) {
                case 'N5':
                    $value3 = '5';
                    break;
                case 'N4':
                    $value3 = '4';
                    break;
                case 'N3':
                    $value3 = '3';
                    break;
                case 'N2':
                    $value3 = '2';
                    break;
                case 'N1':
                    $value3 = '1';
                    break;
            }

            switch ($value4) {
                case 'N5':
                    $value4 = '5';
                    break;
                case 'N4':
                    $value4 = '4';
                    break;
                case 'N3':
                    $value4 = '3';
                    break;
                case 'N2':
                    $value4 = '2';
                    break;
                case 'N1':
                    $value4 = '1';
                    break;
            }

            $thisSkill_se = $row[24];
            if (!empty($thisSkill_se)) {
                $thisSkill_seArr = explode(', ', $thisSkill_se);
                $formatedSkill_seArr = [];
                foreach ($thisSkill_seArr as $val) {
                    $skill_seArr = explode('&', $val);
                    if(count($skill_seArr) == 1) {
                        $formatedVal = $skill_seArr[0] . '&0';
                        array_push($formatedSkill_seArr, $formatedVal);
                    } else {
                        if ($skill_seArr[1] == 1) {
                            $skill_seArr[1] = '趣味or1年未満';
                            $formatedVal = $skill_seArr[0] . '&' . $skill_seArr[1];
                            array_push($formatedSkill_seArr, $formatedVal);
                        } elseif ($skill_seArr[1] == 2) {
                            $skill_seArr[1] = '1年以上';
                            $formatedVal = $skill_seArr[0] . '&' . $skill_seArr[1];
                            array_push($formatedSkill_seArr, $formatedVal);
                        } elseif ($skill_seArr[1] == 3) {
                            $skill_seArr[1] = '2年以上';
                            $formatedVal = $skill_seArr[0] . '&' . $skill_seArr[1];
                            array_push($formatedSkill_seArr, $formatedVal);
                        } elseif ($skill_seArr[1] == 4) {
                            $skill_seArr[1] = '3年以上';
                            $formatedVal = $skill_seArr[0] . '&' . $skill_seArr[1];
                            array_push($formatedSkill_seArr, $formatedVal);
                        } elseif ($skill_seArr[1] == 5) {
                            $skill_seArr[1] = '5年以上';
                            $formatedVal = $skill_seArr[0] . '&' . $skill_seArr[1];
                            array_push($formatedSkill_seArr, $formatedVal);
                        } else {
                            $skill_seArr[1] = 0;
                            $formatedVal = $skill_seArr[0] . '&' . $skill_seArr[1];
                            array_push($formatedSkill_seArr, $formatedVal);
                        }
                    }
                }
                $formatedSkill_se = implode(", ", $formatedSkill_seArr);
                $row[24] = $formatedSkill_se;
            }


            $data = [
                'name' => $row[2],
                'name_kana' => $row[3],
                'sex' => $row[4],
                'birthday' => $row5,
                'age' => $row[6],
                'country' => $row[7],

                'first_interv_date' => $row[8],
                'first_interv_staff' => $row[9],
                'first_interv_result' => $row[10],

                'sec_interv_date' => $row[11],
                'sec_interv_staff' => $row[12],
                'sec_interv_result' => $row[13],

                'intern_interv_date' => $row[14],
                'intern_department' => $row[15],
                'intern_result' => $row[16],
                'hire_date' => $row[17],

                'phone' => $row[18],
                'email' => $row[19],

                'skill_jlpt' => $value1,
                'skill_hearing' => $value2,
                'skill_speaking' => $value3,
                'skill_reading' => $value4,
                'skill_se' => $row[24],

                'graduate_4' => $row[25],
                'graduate_2' => $row[26],
                'graduate_school' => $row[27],

                'apply_department' => $row[28],
                'working_place' => $row[29],
                'current_status' => $row[30],
                'note' => $row[31],
                'folder_name' => $row[33],
            ];

            //名前は空だったら飛ばします
            if ($row[2] === null) {
                $m++;
                continue;
            }

            $validator = Validator::make($data, $this->rules());

            //skill_seはskillsの子供じゃないとき、違う値を表示
            $skill_ses = DB::table('skills')->pluck('name')->toArray();
            $skill_se_error = explode(', ', $row[24]);
            $newErr = [];
            foreach ($skill_se_error as $val) {
                $skill = explode('&', $val);
                array_push($newErr, $skill[0]);
            }
            $diff_skill_se = array_diff($newErr, $skill_ses);
            $skill_se_string = implode(",", $diff_skill_se);

            //interv_staffsはinterv_staffの子供じゃないとき、違う値を表示
            $interv_staffs = DB::table('staffs')->pluck('name')->toArray();
            $arrFirst_interv_staff = explode(',', $row[9]);
            $diff_first_interv_staff = array_diff($arrFirst_interv_staff, $interv_staffs);
            $first_interv_staff_string = implode(",", $diff_first_interv_staff);
            $arrSec_interv_staff = explode(',', $row[12]);
            $diff_sec_interv_staff = array_diff($arrSec_interv_staff, $interv_staffs);
            $sec_interv_staff_string = implode(",", $diff_sec_interv_staff);

            //apply_departmentsはskillsの子供じゃないとき、違う値を表示
            $apply_departments = DB::table('apply_departments')->pluck('name')->toArray();
            $arrApply_department = explode(',', $row[28]);
            $diff_apply_department = array_diff($arrApply_department, $apply_departments);
            $apply_department_string = implode(",", $diff_apply_department);

            //skill_seはskillsの子供じゃないとき、違う値を表示
            $working_places = DB::table('working_places')->pluck('name')->toArray();
            $arrWorking_place = explode(',', $row[29]);
            $diff_working_place = array_diff($arrWorking_place, $working_places);
            $working_place_string = implode(",", $diff_working_place);


            if ($validator->fails()) {
                $errors = $validator->errors()->getMessages();
                foreach ($errors as $column => $messages) {
                    if ($column === 'name') {
                        $errors_array[] = '氏名の' . $m . '行目を違っています';
                    }
                    if ($column === 'name_kana') {
                        $errors_array[] = '氏名カタカナの' . $m . '行目を違っています';
                    }
                    if ($column === 'sex') {
                        $errors_array[] = '性の' . $m . '行目を違っています';
                    }
                    if ($column === 'age') {
                        $errors_array[] = '年齢の' . $m . '行目を違っています';
                    }
                    if ($column === 'country') {
                        $errors_array[] = '国の' . $m . '行目を違っています';
                    }
                    if ($column === 'first_interv_date') {
                        $errors_array[] = 'ー次面接日にちの' . $m . '行目を違っています';
                    }
                    if ($column === 'first_interv_staff') {
                        $errors_array[] = 'ー次面接担当者の' . $m . '行目を違っています。'  . $first_interv_staff_string . 'ではありません';
                    }
                    if ($column === 'first_interv_result') {
                        $errors_array[] = 'ー次面接結果の' . $m . '行目を違っています';
                    }
                    if ($column === 'sec_interv_date') {
                        $errors_array[] = '二次面接日にちの' . $m . '行目を違っています';
                    }
                    if ($column === 'sec_interv_staff') {
                        $errors_array[] = '二次面接担当者の' . $m . '行目を違っています。'  . $sec_interv_staff_string . 'ではありません';
                    }
                    if ($column === 'sec_interv_result') {
                        $errors_array[] = '二次面接結果の' . $m . '行目を違っています';
                    }
                    if ($column === 'intern_interv_date') {
                        $errors_array[] = 'インタン次面接日にちの' . $m . '行目を違っています';
                    }
                    if ($column === 'intern_department') {
                        $errors_array[] = 'インタン次面接担当者の' . $m . '行目を違っています';
                    }
                    if ($column === 'intern_result') {
                        $errors_array[] = 'インタン次面接結果の' . $m . '行目を違っています';
                    }
                    if ($column === 'hire_date') {
                        $errors_array[] = '入社日の' . $m . '行目を違っています';
                    }
                    if ($column === 'email') {
                        $errors_array[] = 'メールの' . $m . '行目を違っています';
                    }
                    if ($column === 'skill_jlpt') {
                        $errors_array[] = '日本語JLPTの' . $m . '行目を違っています';
                    }
                    if ($column === 'skill_se') {
                        $errors_array[] = 'SEスキルの' . $m . '行目を違っています。' . $skill_se_string . 'ではありません';
                    }
                    if ($column === 'apply_department') {
                        $errors_array[] = '応募職種の' . $m . '行目を違っています。' . $apply_department_string . 'ではありません';
                    }
                    if ($column === 'working_place') {
                        $errors_array[] = '希望勤務地の' . $m . '行目を違っています。' . $working_place_string . 'ではありません';
                    }
                    if ($column === 'phone') {
                        $errors_array[] = '電話番号の' . $m . '行目を違っています。';
                    }
                }

                return back()->withErrors(new \Illuminate\Support\MessageBag([$errors_array]));
            }

            Student::create($data);
            $m++;
        }
    }

    public function rules(): array
    {
        //skill_masterテーブルのnameカラムのデータ と
        //studentsテーブルのskill_seカラムを比べる
        $allowedValues = DB::table('skills')->pluck('name')->toArray();
        $interv_staffs = DB::table('staffs')->pluck('name')->toArray();
        $apply_departments = DB::table('apply_departments')->pluck('name')->toArray();
        $working_places = DB::table('working_places')->pluck('name')->toArray();
        return [
            'name' => ['regex:/^[^\p{Hiragana}\p{Katakana}\x{1F000}-\x{1F9FF}\p{P}]+$/u'],
            'name_kana' => ['nullable', 'regex:/^[\p{Katakana}\s]+$/u'],
            'sex' => ['nullable', 'regex:/^(女|男|1|2|0)$/'],
            'phone' => ['nullable', 'regex:/^\+?\d+(?:\(\d+\)|-\d+)*(?:\s*\d+(?:\(\d+\)|-\d+)*)*$/'],

            //結果は　「不合格」　また　「合格」
            'first_interv_staff' => [
                'nullable',
                function ($attribute, $value, $fail) use ($interv_staffs) {
                    $valueArray = explode(',', $value); // split string into array
                    if (count(array_intersect($valueArray, $interv_staffs)) !== count($valueArray)) {
                        $fail($attribute . ' 違います');
                    }
                },
            ],
            'first_interv_result' => ['nullable', 'regex:/^(0|1|2)$/'],
            'sec_interv_staff' => [
                'nullable',
                function ($attribute, $value, $fail) use ($interv_staffs) {
                    $valueArray = explode(',', $value); // split string into array
                    if (count(array_intersect($valueArray, $interv_staffs)) !== count($valueArray)) {
                        $fail($attribute . ' 違います');
                    }
                },
            ],
            'sec_interv_result' => ['nullable', 'regex:/^(0|1|2)$/'],
            'intern_result' => ['nullable', 'regex:/^(0|1|2)$/'],

            'skill_se' => [
                'nullable',
                function ($attribute, $value, $fail) use ($allowedValues) {
                    $valueArray = explode(', ', $value); // split string into array
                    $newArr = [];
                    foreach ($valueArray as $val) {
                        $skill = explode('&', $val);
                        array_push($newArr, $skill[0]);
                    }
                    if (count(array_intersect($newArr, $allowedValues)) !== count($newArr)) {
                        $fail($attribute . ' 違います');
                    }
                },
            ],
            //日本語のレベルは　N5ーN1
            'skill_jlpt' => ['nullable', 'regex:/^(1|2|3|4|5|6)$/'],
            'skill_hearing' => ['nullable', 'regex:/^(1|2|3|4|5)$/'],
            'skill_speaking' => ['nullable', 'regex:/^(1|2|3|4|5)$/'],
            'skill_reading' => ['nullable', 'regex:/^(1|2|3|4|5)$/'],

            'apply_department' => [
                'nullable',
                function ($attribute, $value, $fail) use ($apply_departments) {
                    $valueArray = explode(',', $value); // split string into array
                    if (count(array_intersect($valueArray, $apply_departments)) !== count($valueArray)) {
                        $fail($attribute . ' 違います');
                    }
                },
            ],
            'working_place' => [
                'nullable',
                function ($attribute, $value, $fail) use ($working_places) {
                    $valueArray = explode(',', $value); // split string into array
                    if (count(array_intersect($valueArray, $working_places)) !== count($valueArray)) {
                        $fail($attribute . ' 違います');
                    }
                },
            ],
            //チェックした内容は　「〇」また null
            'graduate_2' => ['nullable', 'regex:/^(0|1)$/'],
            'graduate_4' => ['nullable', 'regex:/^(0|1)$/'],
        ];
    }
}
