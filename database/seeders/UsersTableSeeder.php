<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    /**
     * Generate a random 10-digit phone number.
     *
     * @return string
     */

    private function generatePhoneNumber()
    {
        return '9' . str_pad(rand(0, 999999999), 9, '0', STR_PAD_LEFT);
    }
    public function run(): void
    {

        DB::table('users')->insert([
            // user 1
            [
                'role_id' => 1,
                'name' => 'Paddy',
                'email' => 'loremcodes@gmail.com',
                'phone' => '9004298600',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // user 2
            [
                'role_id' => 2,
                'name' => 'Prathamesh Salunkhe',
                'email' => 'prathamesh@gmail.com',
                'phone' => '9920882371',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // user 3
            [
                'role_id' => 2,
                'name' => 'Pawan Panchal',
                'email' => 'pawan@gmail.com',
                'phone' => '9920882372',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        for ($i = 0; $i < 20; $i++) {
            $phone = $this->generatePhoneNumber();
            while (DB::table('users')->where('phone', $phone)->exists()) {
                $phone = $this->generatePhoneNumber();
            }

            DB::table('users')->insert([
                'name' => Str::random(10),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'phone' => $phone,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
