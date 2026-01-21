<?php

namespace App\Providers;

use App\Services\MailConfigService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // Load mail configuration from database
        try {
            if (app()->environment() !== 'testing') {
                $mailConfig = app(MailConfigService::class);
                $mailConfig->loadFromDatabase();
            }
        } catch (\Exception $e) {
            // Silently fail during migrations or when database is not ready
            \Log::debug('Mail config not loaded: ' . $e->getMessage());
        }
    }
}
