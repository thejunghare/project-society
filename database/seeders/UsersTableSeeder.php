<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // user 1
            [
                'role_id' => 1,
                'name' => 'paddy',
                'email' => 'paddy@gmail.com',
                'phone' => '900481065',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // user 2
            [
                'role_id' => 2,
                'name' => 'prathamesh',
                'email' => 'prathamesh@gmail.com',
                'phone' => '90048104',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
             // user 2
             [
                'role_id' => 3,
                'name' => 'prasad',
                'email' => 'prasad@gmail.com',
                'phone' => '900410654',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
             ],
        ]);
    }
}
