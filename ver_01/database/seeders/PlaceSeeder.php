<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $places = [[
            'name' => '',
        ],[
            'name' => '東京',
        ],[
            'name' => '大阪',
        ],[
            'name' => '名古屋',
        ],[
            'name' => '埼玉',
        ],[
            'name' => '神戸',
        ],[
            'name' => '札幌',
        ]];
        Place::insert($places);
    }
}
