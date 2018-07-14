<?php

namespace Laravelista\Loki;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Routing\UrlGenerator as LaravelUrlGenerator;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        // $this->app['router']->pushMiddlewareToGroup('web', Heimdall::class);
        $this->app['router']->aliasMiddleware('loki', Middleware::class);

        $this->publishes([
            __DIR__ . '/../config/loki.php' => config_path('loki.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../routes/loki.web.php' => base_path('routes/loki.web.php'),
        ], 'route');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/loki.php',
            'loki'
        );

        $this->app->extend(LaravelUrlGenerator::class, function ($generator) {
            return new UrlGenerator($this->app['router']->getRoutes(), $generator->getRequest());
        });
    }
}