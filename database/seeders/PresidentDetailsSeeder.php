<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PresidentDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('president_details')->insert([
            // president one
            [
                'name' => 'John Cena',
                'email' => 'john@gmail.com',
                'phone' => '9004289600',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // president two
            [
                'name' => 'Seth Rollins',
                'email' => 'seth@gmail.com',
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
