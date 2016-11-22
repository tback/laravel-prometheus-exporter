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
        return $this->request->getPathInfo();
    }
}
