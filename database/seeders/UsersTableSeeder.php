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
                'name' => 'Prasad Junghare',
                'email' => fake()->unique()->safeEmail(),
                'phone' => '9004298600',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // user 2
            [
                'role_id' => 2,
                'name' => 'Prathamesh Salunkhe',
                'email' => fake()->unique()->safeEmail(),
                'phone' => '9920882371',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

              // user 3
              [
                'role_id' => 2,
                'name' => 'Pawan Panchal',
                'email' => fake()->unique()->safeEmail(),
                'phone' => '9920882372',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
             // user 4
             [
                'role_id' => 3,
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '900486900',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
             ],
              // user 5
              [
                'role_id' => 3,
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '900410654',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
             ],
              // user 6
              [
                'role_id' => 3,
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '9004106548',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
             ],
        ]);
    }
}
