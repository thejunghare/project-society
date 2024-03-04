<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('bills')->insert([
            //  one
            [
                'member_id' => 11,
                'amount' => 500.00,
                'status' => 0,
                'billing_month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //  two
            [
                'member_id' => 12,
                'amount' => 500.00,
                'status' => 0,
                'billing_month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //  three
            [
                'member_id' => 1,
                'amount' => 500.00,
                'status' => 0,
                'billing_month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //  four
            [
                'member_id' => 2,
                'amount' => 500.00,
                'status' => 0,
                'billing_month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //  five
            [
                'member_id' => 16,
                'amount' => 500.00,
                'status' => 0,
                'billing_month' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
