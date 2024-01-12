<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'admin@admin.admin',
                'email' => 'admin@admin.admin',
                'role' => 2,
                'password' => bcrypt('admin@admin.admin'),
            ],
            [
                'name' => 'editor@editor.editor',
                'email' => 'editor@editor.editor',
                'role' => 1,
                'password' => bcrypt('editor@editor.editor'),
            ],
            [
                'name' => 'user@user.user',
                'email' => 'user@user.user',
                'role' => 0,
                'password' => bcrypt('user@user.user'),
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
