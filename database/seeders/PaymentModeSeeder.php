<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('payment_modes')->insert([
            // role one
            [
                'mode' => 'online',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // role two
            [
                'mode' => 'cheque',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // role three
            [
                'mode' => 'cash',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
