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
        DB::table('societies')->insert([
            // Society one
            [
                'name' => 'Vighaneshwar',
                'address' => 'Plot no B 420, Sector 4, Ghansoli, Navi Mumbai, Maharashtra 400701',
                'phone' => '9004289600',
                'member_count' => 26,
                'president_name' => 'name',
                'vice_president_name' => 'name',
                'treasurer_name' => 'name',
                'secretary_name' => 'name',
                'bank_name' => 'citibank',
                'bank_ifsc_code' => '1',
                'bank_account_number' => '1',
                'accountant_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'renews_at' => now()->addYear(), // Renew date set to one year from now
            ],

            // Society two
            [
                'name' => 'Mauli',
                'address' => 'Plot no B 421, Sector 5, Ghansoli, Navi Mumbai, Maharashtra 400701',
                'phone' => '9920882371',
                'member_count' => 26,
                'president_name' => 'name',
                'vice_president_name' => 'name',
                'treasurer_name' => 'name',
                'secretary_name' => 'name',
                'bank_name' => 'citibank',
                'bank_ifsc_code' => '1',
                'bank_account_number' => '2',
                'accountant_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'renews_at' => now()->addYear(), // Renew date set to one year from now
            ],

            // Society three
            [
                'name' => 'Balaji',
                'address' => 'Plot no B 422, Sector 4, Ghansoli, Navi Mumbai, Maharashtra 400701',
                'phone' => '9004286900',
                'member_count' => 26,
                'president_name' => 'name',
                'vice_president_name' => 'name',
                'treasurer_name' => 'name',
                'secretary_name' => 'name',
                'bank_name' => 'citibank',
                'bank_ifsc_code' => '1',
                'bank_account_number' => '3',
                'accountant_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'renews_at' => now()->addYear(), // Renew date set to one year from now
            ],
        ]);
    }
}
