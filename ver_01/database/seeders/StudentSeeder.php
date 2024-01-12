<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $student = [[
            'name' => 'Nguyen Van Hung',
            'name_kana' => 'グエン　ヴァン　フン',
            'sex' => '1',
            'birthday' => '2023-03-28',
            'age' => '23',
            'country' => 'ベトナム',
            'first_interv_date' => '2023-04-05',
            'first_interv_staff' => '成田',
            'first_interv_result' => '0',
            'sec_interv_date' => '2023-04-05',
            'sec_interv_staff' => '成田',
            'sec_interv_result' => '0',
            'intern_interv_date' => '2023-04-05',
            'intern_department' => 'SE',
            'intern_result' => '0',
            'hire_date' => '2023-04-05',
            'phone' => '08043900311',
            'email' => 'hung@gmail.com',
            'skill_jlpt' => '2',
            'skill_hearing' => '2',
            'skill_speaking' => '2',
            'skill_reading' => '2',
            'skill_se' => 'Java,HTML,CSS,Swift,C++',
            'graduate_4' => '0',
            'graduate_2' => '1',
            'graduate_school' => '専門学校',
            'apply_department' => 'SE',
            'working_place' => '大阪',
            'current_status' => '卒業済み',
            'note' => 'SEになりたいです。',
        ], [
            'name' => 'Duong Huu Tien',
            'name_kana' => 'ユオン　ヴァン　テイエン',
            'sex' => '1',
            'birthday' => '2023-03-28',
            'age' => '23',
            'country' => 'ベトナム',
            'first_interv_date' => '2023-04-05',
            'first_interv_staff' => '成田',
            'first_interv_result' => '0',
            'sec_interv_date' => '2023-04-05',
            'sec_interv_staff' => '成田',
            'sec_interv_result' => '0',
            'intern_interv_date' => '2023-04-05',
            'intern_department' => 'SE',
            'intern_result' => '0',
            'hire_date' => '2023-04-05',
            'phone' => '08043900312',
            'email' => 'tien@gmail.com',
            'skill_jlpt' => '3',
            'skill_hearing' => '2',
            'skill_speaking' => '3',
            'skill_reading' => '2',
            'skill_se' => 'Java,HTML,CSS,PHP',
            'graduate_4' => '0',
            'graduate_2' => '1',
            'graduate_school' => '専門学校',
            'apply_department' => 'SE',
            'working_place' => '大阪',
            'current_status' => '卒業済み',
            'note' => 'SEになりたいです。',
        ]];
        Student::insert($student);
    }
}
