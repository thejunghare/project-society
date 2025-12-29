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
                'due_date' => 15,
                'member_count' => 26,
                'president_name' => 'name',
                'vice_president_name' => 'name',
                'treasurer_name' => 'name',
                'secretary_name' => 'name',
                'bank_name' => 'citibank',
                'bank_ifsc_code' => '1',
                'bank_account_number' => '1',
                'upi_id' => 'vighaneshwar@upi',
                'upi_number' => '9004289600@upi',
                'parking_charges' => 50.00,
                'service_charges' => 100.00,
                'maintenance_amount_owner' => 2000.00,
                'maintenance_amount_rented' => 1500.00,
                'late_fee' => 100.00, // Adding late fee
                // 'maintenance_due_date' => '2024-01-05',
                'accountant_id' => 2,
                'registered_balance' => 0,
                'updated_balance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'renews_at' => now()->addYear(), // Renew date set to one year from now
            ],

            // Society two
            [
                'name' => 'Mauli',
                'address' => 'Plot no B 421, Sector 5, Ghansoli, Navi Mumbai, Maharashtra 400701',
                'phone' => '9920882371',
                'due_date' => 10,
                'member_count' => 26,
                'president_name' => 'name',
                'vice_president_name' => 'name',
                'treasurer_name' => 'name',
                'secretary_name' => 'name',  
                'bank_name' => 'citibank',
                'bank_ifsc_code' => '1',
                'bank_account_number' => '2',
                'upi_id' => 'mauli@upi',
                'upi_number' => '9920882371@upi',
                'parking_charges' => 75.00,
                'service_charges' => 125.00,
                'maintenance_amount_owner' => 1800.00,
                'maintenance_amount_rented' => 1200.00,
                'late_fee' => 80.00, // Adding late fee
                // 'maintenance_due_date' => '2024-01-05',
                'accountant_id' => 3,
                'registered_balance' => 0,
                'updated_balance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'renews_at' => now()->addYear(), // Renew date set to one year from now
            ],

            // Society three
            [
                'name' => 'Balaji',
                'address' => 'Plot no B 422, Sector 4, Ghansoli, Navi Mumbai, Maharashtra 400701',
                'phone' => '9004286900',
                'due_date' => 13,
                'member_count' => 26,
                'president_name' => 'name',
                'vice_president_name' => 'name',
                'treasurer_name' => 'name',
                'secretary_name' => 'name',
                'bank_name' => 'citibank',
                'bank_ifsc_code' => '1',
                'bank_account_number' => '3',
                'upi_id' => 'balaji@upi',
                'upi_number' => '9004286900@upi',
                'parking_charges' => 60.00,
                'service_charges' => 110.00,
                'maintenance_amount_owner' => 1900.00,
                'maintenance_amount_rented' => 1300.00,
                'late_fee' => 90.00, // Adding late fee
                'accountant_id' => 2,
                'registered_balance' => 0,
                'updated_balance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'renews_at' => now()->addYear(), // Renew date set to one year from now
            ],
        ]);
    }
}
