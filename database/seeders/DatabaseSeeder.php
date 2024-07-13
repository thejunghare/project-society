<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MaintenanceBillSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(PaymentModeSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AccountantSeeder::class);
        $this->call(SocietiesSeeder::class);
        $this->call(MembersSeeder::class);
        $this->call(MaintenanceBillSeeder::class);
        $this->call(PaymentSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
