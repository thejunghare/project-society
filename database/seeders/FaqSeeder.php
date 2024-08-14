<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds
     */
    public function run(): void
    {
        DB::table('faqs')->insert([
            [
                'question' => 'question one',
                'answer' => 'answer one',
                 'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'question' => 'question two',
                'answer' => 'answer two',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'question three',
                'answer' => 'answer three',
                 'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }}
