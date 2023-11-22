<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;  
use App\Http\ViewComposers\HeaderMenuComposer;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Verify\Service',
            'App\Services\Twilio\Verification'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    { 
        View::composer('layout.common.app-header', HeaderMenuComposer::class);
    }
}
