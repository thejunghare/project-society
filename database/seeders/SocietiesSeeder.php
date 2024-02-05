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
            // Society one
            [
                'name' => 'Vighaneshwar',
                'address' => 'Plot no B 420, Sector 4, Ghansoli, Navi Mumbai, Maharashtra 400701',
                'phone' => '9004289600',
                'member_count' => 26,
                'president_id' => 1,
                'vice_president_id' => 1,
                'secretary_id' => 1,
                'treasurer_id' => 1,
                'accountant_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Society two
            [
                'name' => 'Mauli',
                'address' => 'Plot no B 421, Sector 5, Ghansoli, Navi Mumbai, Maharashtra 400701',
                'phone' => '9920882371',
                'member_count' => 26,
                'president_id' => 2,
                'vice_president_id' => 2,
                'secretary_id' => 2,
                'treasurer_id' => 2,
                'accountant_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Society three
            [
                'name' => 'Balaji',
                'address' => 'Plot no B 422, Sector 4, Ghansoli, Navi Mumbai, Maharashtra 400701',
                'phone' => '9004286900',
                'member_count' => 26,
                'president_id' => 3,
                'vice_president_id' => 3,
                'secretary_id' => 3,
                'treasurer_id' => 3,
                'accountant_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
