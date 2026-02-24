<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Page;

class PageServiceProvider extends ServiceProvider
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
        View::composer('public.pages.template.default', function ($view) {

            $slug = request()->segment(1); // about

            $page = Page::where('slug', $slug)->first();

            $view->with('page', $page);
        });
    }
}
