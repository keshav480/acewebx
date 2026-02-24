<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Menu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
        View::composer('public.components.header', function ($view) {
            $menus = Menu::get()->filter(function ($menu) {
              
                $settings = is_array($menu->settings) ? $menu->settings : json_decode($menu->settings, true);
                return ($settings['location'] ?? '') === 'header';
            });
            $view->with('headerMenus', $menus);
        });
    }
}
