<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VicePresidentDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('vice_president_details')->insert([
            // president one
            [
                'name' => 'vice president one',
                'email' => 'vicepresident1@gmail.com',
                'phone' => '789456123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
