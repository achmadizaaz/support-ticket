<?php

namespace App\Providers;

use App\Models\Option;
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
        $option = Option::get();
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
