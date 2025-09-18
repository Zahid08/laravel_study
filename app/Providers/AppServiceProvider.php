<?php

namespace App\Providers;

use App\Contracts\ReportServiceInterface;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Services\ReportService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when([HomeController::class, ReportController::class])
            ->needs(ReportServiceInterface::class)
            ->give(ReportService::class);

//        or / // Just use simple binding if it's the same implementation
//$this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
