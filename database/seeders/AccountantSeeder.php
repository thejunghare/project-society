<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('accountants')->insert([
            //  one
            [
                /* 'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '9004289600',
                'created_at' => now(),
                'updated_at' => now(), */
                'user_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //  two
            [
                /* 'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '99208882371',
                'created_at' => now(),
                'updated_at' => now(), */
                'user_id' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
