<?php

namespace Tback\PrometheusExporter;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;
use Prometheus\Storage\Redis;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('prometheus_exporter.php'),
        ]);

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config.php', 'prometheus_exporter'
        );

        $this->app->singleton('prometheus', function ($app) {
            switch (config('prometheus_exporter.adapter')) {
                case 'apc':
                    $adapter = new APC();
                    break;
                case 'redis':
                    $adapter = new Redis(config('prometheus_exporter.redis'));
                    break;
                default:
                    throw new \ErrorException('"prometheus_exporter.adapter" must be either apc or redis');
            }

            $registry = new CollectorRegistry($adapter);

            return $registry;
        });
    }
}
