<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffs = [[
            'name' => '',
        ],[
            'name' => '成田',
        ],[
            'name' => '新島',
        ],[
            'name' => '西田',
        ]];
        Staff::insert($staffs);
    }
}
