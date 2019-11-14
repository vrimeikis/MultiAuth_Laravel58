<?php

namespace App\Providers;

use App\Services\RouteAccessManagerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(RouteAccessManagerService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadHelpers();
    }

    private function loadHelpers() {
        include_once __DIR__ . '/../../helpers/route_access.php';
    }
}
