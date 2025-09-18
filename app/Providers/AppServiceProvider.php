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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
