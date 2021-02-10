<?php

namespace Trin4ik\RussianCity;

use Grimzy\LaravelMysqlSpatial\SpatialServiceProvider;
use Illuminate\Support\ServiceProvider;
use Trin4ik\RussianCity\Console\ParseRussianCity;

class RussianCityServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
        $this->app->register( SpatialServiceProvider::class);
    }

    public function boot()
    {
        //
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        if ($this->app->runningInConsole()) {
            $this->commands([
                ParseRussianCity::class,
            ]);
        }
    }
}
