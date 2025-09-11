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
        
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('longpassword'),
            'assigned_to_editor_id' => 2,
        ])->assignRole('user');

        // Create posts with random category associations
        Post::factory(50)->create();
    }
}