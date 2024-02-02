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
            // president one
            [
                'name' => 'secretary one',
                'email' => 'secretary1@gmail.com',
                'phone' => '789456123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
