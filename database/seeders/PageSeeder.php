<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // Optional: clear existing pages
        Page::truncate();

        // Create dummy pages
        $pages = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'content' => '<h1>Welcome to Our Website!</h1><p>This is the homepage content.</p>',
                'status' => 'published',
                'order' => 1,
            ],
            [
                'title' => 'About',
                'slug' => 'about',
                'content' => '<h1>About Us</h1><p>Information about our company.</p>',
                'status' => 'published',
                'order' => 2,
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'content' => '<h1>Our Services</h1><p>Details of services we offer.</p>',
                'status' => 'published',
                'order' => 3,
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => '<h1>Contact Us</h1><p>How to reach us.</p>',
                'status' => 'published',
                'order' => 4,
            ],
            [
                'title' => 'Blog',
                'slug' => 'blog',
                'content' => '<h1>Our Blog</h1><p>Latest news and updates.</p>',
                'status' => 'published',
                'order' => 5,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
