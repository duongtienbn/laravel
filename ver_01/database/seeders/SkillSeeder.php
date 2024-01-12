<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $skills = [[
            'name' => 'Java',
        ],[
            'name' => 'HTML',
        ],[
            'name' => 'CSS',
        ],[
            'name' => 'JavaScript',
        ],[
            'name' => 'PHP',
        ],[
            'name' => 'SQL',
        ],[
            'name' => 'C',
        ],[
            'name' => 'C++',
        ],[
            'name' => 'C#',
        ],[
            'name' => 'Python',
        ],[
            'name' => 'Swift',
        ],[
            'name' => 'Objective-c',
        ]];
        Skill::insert($skills);

        // $skills = ['Java', 'C', 'C++', 'FORTRAN', 'COBOL', 'JavaScript', 'Ruby', 'PHP', 'Python', 'GO', 'Swift', 'Kotlin'];
        
        // foreach ($skills as $skill) {
        //     Skill::create(['name' => $skill]);
        // }
    }
}
