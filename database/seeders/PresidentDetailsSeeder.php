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
                'name' => 'president one',
                'email' => 'president1@gmail.com',
                'phone' => '789456123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
