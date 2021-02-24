<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Werkspot\CompressUrl\Drivers\UrlCompressorDriverContract;
use Werkspot\CompressUrl\Drivers\WerkspotUrlDriver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Werkspot's url driver is a default url shortener driver.
        $this->app->bind(UrlCompressorDriverContract::class, WerkspotUrlDriver::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
