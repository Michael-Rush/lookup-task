<?php

namespace App\Providers;

use App\Services\Interfaces\ILookupService;
use App\Services\LookupService;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ILookupService::class, LookupService::class);
    }
}
