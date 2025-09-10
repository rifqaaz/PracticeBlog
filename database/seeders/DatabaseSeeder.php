<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category; 
use App\Models\Post; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('longpassword'),
            'assigned_to_editor_id' => 2, // Assuming editor with ID 2 exists
        ])->assignRole('user');

        User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jj@example.com',
            'password' => bcrypt('12345678'),
            'assigned_to_admin_id' => 3,
        ])->assignRole('editor');

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ])->assignRole('admin');

        // Seed categories
        $categories = [
            'Technology',
            'Health', 
            'Science',
            'Sports',
            'Politics',
            'Entertainment'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => strtolower(str_replace(' ', '-', $category))
            ]);
        }

        // Create posts with random category associations
        Post::factory(20)->create();
    }
}