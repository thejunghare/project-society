<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('roles')->insert([
            // role one
            [
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // role two
            [
                'role' => 'accountant',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // role three
            [
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // role four
            [
                'role' => 'member',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
