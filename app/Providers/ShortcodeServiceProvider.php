<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\ShortcodeManager;

class ShortcodeServiceProvider extends ServiceProvider
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
            //  $test=  ShortcodeManager::register('ace_testimonials_slider', function ($attrs) {
            //     return view('shortcodes.ace_testimonials_slider', $attrs)->render();
            // });
          ShortcodeManager::register('ace_testimonials_slider', function ($attrs) {
             return app(\App\Http\Controllers\public\PublicPageController::class)->shortcode();
        });
    }
}
