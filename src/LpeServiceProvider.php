<?php
namespace Tback\PrometheusExporter;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;
use Prometheus\Storage\Redis;
use Illuminate\Support\ServiceProvider;

/**
 * Class LpeServiceProvider
 * @package Tback\PrometheusExporter
 */
class LpeServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/config.php',
            'prometheus_exporter'
        );

        /**
         * LpeManager
         */
        $this->app->singleton('LpeManager', function () {
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

            return new LpeManager($registry);
        });
    }
}
