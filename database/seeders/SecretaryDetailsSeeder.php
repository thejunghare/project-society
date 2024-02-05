<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SecretaryDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('secretary_details')->insert([
            //  one
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '9004289600',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //  two
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '9920882371',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //  three
            [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '9004286900',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
