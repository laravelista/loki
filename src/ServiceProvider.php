<?php

namespace Laravelista\Loki;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Routing\UrlGenerator;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->app['router']->pushMiddlewareToGroup('web', Heimdall::class);

        $this->publishes([
            __DIR__ . '/../config/loki.php' => config_path('loki.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/loki.php',
            'loki'
        );

        $this->app->extend(UrlGenerator::class, function ($generator) {
            return new Loki($this->app['router']->getRoutes(), $generator->getRequest());
        });
    }
}