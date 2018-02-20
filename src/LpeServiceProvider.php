<?php
namespace Tback\PrometheusExporter;

use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;
use Tback\PrometheusExporter\Middleware\LaravelResponseTimeMiddleware;

/**
 * Class LpeServiceProvider
 * @package Tback\PrometheusExporter
 */
class LpeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $source = realpath(__DIR__ . '/config/config.php');

        if ($this->app instanceof LaravelApplication) {
            $this->publishes([$source => config_path('prometheus_exporter.php')]);
            $this->mergeConfigFrom($source, 'prometheus_exporter');

            $kernel->pushMiddleware(LaravelResponseTimeMiddleware::class);
            if(! $this->app->routesAreCached()){
                $this->registerMetricsRoute();
            }
        } elseif (class_exists('Laravel\Lumen\Application', false)) {
            $this->app->configure('prometheus_exporter');
            $this->mergeConfigFrom($source, 'prometheus_exporter');
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/config.php',
            'prometheus_exporter'
        );


        switch (config('prometheus_exporter.adapter')) {
            case 'apc':
                $this->app->bind('Prometheus\Storage\Adapter', 'Prometheus\Storage\APC');
                break;
            case 'redis':
                $this->app->bind('Prometheus\Storage\Adapter', function($app){
                    return new \Prometheus\Storage\Redis(config('prometheus_exporter.redis'));
                });
                break;
            default:
                throw new \ErrorException('"prometheus_exporter.adapter" must be either apc or redis');
        }
    }

    public function registerMetricsRoute()
    {
        $this->loadRoutesFrom(__DIR__ . '/laravel_routes.php');
    }
}
