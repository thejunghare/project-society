<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expenses')->insert([
            [
                'society_id' => 1,
                'expense_type_id' => 1,
                'amount' => 1500.00,
                'remark' => 'Monthly maintenance cost',
                'bill_month' => 1,
                'bill_year' => 2024,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'society_id' => 1,
                'expense_type_id' => 2,
                'amount' => 500.00,
                'bill_month' => 2,
                'bill_year' => 2024,
                'remark' => 'Garden maintenance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'society_id' => 2,
                'expense_type_id' => 1,
                'amount' => 2500.00,
                'bill_month' => 2,
                'bill_year' => 2024,
                'remark' => 'Electricity bill',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
