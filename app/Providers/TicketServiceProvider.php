<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
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
        view()->composer(
            'layouts.header',
            function ($view) {
                // Notifikasi
                $notifications = Auth::user()->unreadNotifications
                ->where('type', 'App\Notifications\TicketNotification');

                // Get 10 notifikasi
                $notifications->take(10);

                $view->with([
                    'notifications' => $notifications,
                ]);
            }
        );

    }
}
