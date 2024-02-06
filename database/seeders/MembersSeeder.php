<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        /* DB::table('members')->insert([
            // member one
            [
                'society_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]); */

        DB::table('members')->insert([
            // 10 members for society_id 1
            ...array_map(function ($userId) {
                return [
                    'society_id' => 1,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, range(4, 13)),
            // 5 members for society_id 2
            ...array_map(function ($userId) {
                return [
                    'society_id' => 2,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, range(14, 18)),
            // 5 members for society_id 3
            ...array_map(function ($userId) {
                return [
                    'society_id' => 3,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, range(19, 23))
        ]);


    }
}
