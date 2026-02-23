<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        logger('NotificationProvider boot is running!');

            View::composer('*', function ($view) {
                if (Auth::check()) {
                    $userId = Auth::id();
                    $notifications = Notification::where('notifiable_id', $userId)
                        ->latest()
                        ->take(10)
                        ->get();
                    $unreadCount = Notification::where('notifiable_id', $userId)
                        ->whereNull('read_at')
                        ->count();
                } else {
                    $notifications = collect();
                    $unreadCount = 0;
                }

                $view->with([
                    'headerNotifications' => $notifications,
                    'unreadCount' => $unreadCount
                ]);
            });
        }

}
