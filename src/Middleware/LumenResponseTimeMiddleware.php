<?php
namespace Tback\PrometheusExporter\Middleware;

/**
 * Class LumenResponseTimeMiddleware
 * @package Tback\PrometheusExporter\Middleware
 */
class LumenResponseTimeMiddleware extends AbstractResponseTimeMiddleware
{
    /**
     * Get route name
     *
     * @return string
     */
    protected function getRouteName()
    {
        $route_info = $this->request->route()[1];
        return array_key_exists('as', $route_info) ? $route_info['as']: 'unnamed';
    }
}
