<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ])->assignRole('admin');
        
        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jj@example.com',
            'password' => bcrypt('12345678'),
            'assigned_to_admin_id' => 1,
        ])->assignRole('editor');

    }
}

