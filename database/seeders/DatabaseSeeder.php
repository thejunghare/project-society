<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PresidentDetailsSeeder::class);
        $this->call(VicePresidentDetailsSeeder::class);
        $this->call(SecretaryDetailsSeeder::class);
        $this->call(TreasurerDetailsSeeder::class);
        $this->call(AccountantSeeder::class);
        $this->call(SocietiesSeeder::class);
        $this->call(MembersSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
