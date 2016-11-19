<?php

namespace Tback\PrometheusExporter;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
    }

    public function register()
    {
        $this->app->singleton('prometheus', function ($app) {
            $adapter = new APC();
            $registry = new CollectorRegistry($adapter);

            return $registry;
        });
    }
}
