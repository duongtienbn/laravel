<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apply;

class ApplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $applies = [[
            'name' => '',
        ],[
            'name' => 'SE',
        ],[
            'name' => '営業',
        ]];
        Apply::insert($applies);
    }
}
