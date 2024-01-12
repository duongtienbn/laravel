<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $countrys = [[
            'name' => '',
        ],[
            'name' => '日本',
        ],[
            'name' => 'アメリカ',
        ],[
            'name' => 'ロシア',
        ],[
            'name' => 'ウズベキスタン',
        ],[
            'name' => 'バングラデシュ',
        ],[
            'name' => 'ベトナム',
        ],[
            'name' => 'イギリス',
        ],[
            'name' => 'フランス',
        ],[
            'name' => 'ドイツ',
        ]];
        Country::insert($countrys);
    }
}
