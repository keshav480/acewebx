<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing pages (optional, for fresh seed)
        Page::truncate();

        // Create dummy Home page
        Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'content' => '<h1>Welcome to Our Website!</h1><p>This is the homepage content.</p>',
            'status' => 'published',
            'order' => 1,
        ]);
    }
}
