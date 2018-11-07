<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function register()
    {
        $this->app->bind('AreaInfoRepository', \App\Repositories\AreaInfoRepository::class);
        $this->app->bind('NearestStationRepository', \App\Repositories\NearestStationRepository::class);
    }
}
