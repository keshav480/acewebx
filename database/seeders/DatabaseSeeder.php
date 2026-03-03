<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SettingsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call([PageSeeder::class,]);
        $this->call([MenuSeeder::class,]);
        $this->call([RoleSeeder::class,]);
        $this->call([PermissionSeeder::class]); 
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
            ]
        );
    }
}
