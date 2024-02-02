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
            // president one
            [
                'name' => 'accountant one',
                'email' => 'accountant1@gmail.com',
                'phone' => '789456123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
