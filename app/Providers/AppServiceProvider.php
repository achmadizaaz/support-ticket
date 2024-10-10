<?php

namespace App\Providers;

use App\Models\Option;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $url);
        });


        $option = Schema::hasTable('options') ? $option = Option::get() : [];
        view()->composer(
            'layouts.main',
            function ($view) use ($option) {
                $view->with([
                    'option'=>  $option->keyBy('name'),
                ]);
            }
        );
        view()->composer(
            'layouts.header',
            function ($view) use ($option) {
                $view->with([
                    'option'=>  $option->keyBy('name'),
                ]);
            }
        );
        view()->composer(
            'layouts.footer',
            function ($view) use ($option) {
                $view->with([
                    'option'=>  $option->keyBy('name'),
                ]);
            }
        );

    }
}
