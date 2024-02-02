<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SocietiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        DB::table('societies')->insert([
            // role one
            [
                'name' => 'developer',
                'address' => 'developer',
                'member_count' => 26,
                'president_id' => 1,
                'vice_president_id' => 1,
                'secretary_id' => 1,
                'treasurer_id' => 1,
                'accountant_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
