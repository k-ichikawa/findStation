<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function register()
    {
        $this->app->bind('AreaService', \App\Services\AreaService::class);
        $this->app->bind('StationService', \App\Services\StationService::class);
        $this->app->bind('MapService', \App\Services\MapService::class);
    }
}
