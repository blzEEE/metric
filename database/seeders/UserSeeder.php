<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 2,
            'email' => 'user@example.com',
            'surname' => 'Администратор',
            'name' => 'Организации',
            'password' => Hash::make('password'),
            'company_id' => 1,
            'user_role_id' => 3,
            'user_status_id' => 1
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'email' => 'operator@example.com',
            'surname' => 'Оператор',
            'name' => 'Организации',
            'password' => Hash::make('password'),
            'company_id' => 1,
            'user_role_id' => 4,
            'user_status_id' => 1
        ]);
    }
}
