<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MaintenanceBillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('maintenance_bills')->insert([
            //  one
            [
                'member_id' => 11,
                'amount' => 500.00,
                'status' => 0,
                'due_date' => '2024-01-05 07:27:31',
                'billing_month' => 1,
                'billing_year' => 2024,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //  two
            [
                'member_id' => 12,
                'amount' => 500.00,
                'status' => 0,
                'due_date' => '2024-01-05 07:27:31',
                'billing_month' => 1,
                'billing_year' => 2024,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //  three
            [
                'member_id' => 1,
                'amount' => 500.00,
                'status' => 0,
                'due_date' => '2024-01-05 07:27:31',
                'billing_month' => 1,
                'billing_year' => 2024,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //  four
            [
                'member_id' => 2,
                'amount' => 500.00,
                'status' => 0,
                'due_date' => '2024-01-05 07:27:31',
                'billing_month' => 1,
                'billing_year' => 2024,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //  five
            [
                'member_id' => 16,
                'amount' => 500.00,
                'status' => 0,
                'due_date' => '2024-01-05 07:27:31',
                'billing_month' => 1,
                'billing_year' => 2024,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
