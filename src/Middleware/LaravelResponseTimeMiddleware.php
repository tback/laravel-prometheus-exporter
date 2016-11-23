<?php
namespace Tback\PrometheusExporter\Middleware;

/**
 * Class LaravelResponseTimeMiddleware
 * @package Tback\PrometheusExporter\Middleware
 */
class LaravelResponseTimeMiddleware extends AbstractResponseTimeMiddleware
{
    /**
     * Get route name
     *
     * @return string
     */
    protected function getRouteName()
    {
        return \Route::currentRouteName() ?: 'unnamed';
    }
}
