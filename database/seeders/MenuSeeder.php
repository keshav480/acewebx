<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        Menu::truncate(); // optional: clear old data

        // Header Menu
        Menu::create([
            'name' => 'Header Menu',
            'data' => [
                ['id' => 1, 'title' => 'Home', 'url' => '/', 'parent_id' => null],
                ['id' => 2, 'title' => 'About', 'url' => '/about', 'parent_id' => null],
                ['id' => 3, 'title' => 'Services', 'url' => '/services', 'parent_id' => null],
                ['id' => 4, 'title' => 'Contact', 'url' => '/contact', 'parent_id' => null],
            ],
            'settings' => [
                'auto_add_pages' => false,
                'location' => 'header'
            ],
        ]);

        // Footer Menu
        Menu::create([
            'name' => 'Footer Menu',
            'data' => [
                ['id' => 5, 'title' => 'Privacy Policy', 'url' => '/privacy', 'parent_id' => null],
                ['id' => 6, 'title' => 'Terms of Service', 'url' => '/terms', 'parent_id' => null],
            ],
            'settings' => [
                'auto_add_pages' => false,
                'location' => 'footer'
            ],
        ]);
    }
}
