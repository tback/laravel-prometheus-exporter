<?php


namespace Tback\PrometheusExporter;

use Prometheus\Storage\APC;
use Prometheus\CollectorRegistry;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }
    }

    public function register()
    {
        $this->app->singleton('prometheus', function ($app){
            $adapter = new APC();
            $registry = new CollectorRegistry($adapter);

            return $registry;
        });
    }
}
