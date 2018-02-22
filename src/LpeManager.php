<?php
namespace Tback\PrometheusExporter;

use Illuminate\Foundation\Http\Kernel;
use Illuminate\Routing\Router;
use Prometheus\CollectorRegistry;
use Prometheus\Counter;

/**
 * Class LpeManager
 *
 * @author  Christopher Lorke <lorke@traum-ferienwohnungen.de>
 * @package Tback\PrometheusExporter
 */
class LpeManager
{
    /**
     * @var CollectorRegistry
     */
    protected $registry;

    /**
     * @var Counter
     */
    protected $requestCounter;

    /**
     * @var Counter
     */
    protected $requestDurationCounter;

    /**
     * LpeManager constructor.
     *
     * @param CollectorRegistry $registry
     */
    public function __construct(CollectorRegistry $registry, Router $router)
    {
        $this->registry = $registry;
        $routeNames = [];
        foreach($router->getRoutes() as $route){
            $routeNames[] = $route->getName();
        }
        $this->initRouteMetrics($routeNames);
    }

    public function initRouteMetrics(array $routes)
    {
        static $run = false;
        if (!$run){
            $run = true;

            $namespace = config('prometheus_exporter.namespace_http_server');
            $labelNames = $this->getRequestCounterLabelNames();

            $name = 'requests_total';
            $help = 'number of http requests';
            $this->requestCounter = $this->registry->registerCounter($namespace, $name, $help, $labelNames);

            $name = 'requests_latency_milliseconds';
            $help = 'duration of http_requests';
            $this->requestDurationCounter = $this->registry->registerCounter($namespace, $name, $help, $labelNames);

            foreach ($routes as $route) {
                foreach (config('prometheus_exporter.init_metrics_for_http_methods') as $method) {
                    foreach (config('prometheus_exporter.init_metrics_for_http_status_codes') as $statusCode) {
                        $labelValues = [(string)$route, (string)$method, (string) $statusCode];
                        $this->requestCounter->incBy(0, $labelValues);
                        $this->requestDurationCounter->incBy(0.0, $labelValues);
                   }
               }
            }
        }
    }

    protected function getRequestCounterLabelNames()
    {
        return [
            'route', 'method', 'status_code',
        ];
    }

    public function countRequest($route, $method, $statusCode, $duration_milliseconds)
    {
        $labelValues = [(string)$route, (string)$method, (string) $statusCode];
        $this->requestCounter->inc($labelValues);
        $this->requestDurationCounter->incBy($duration_milliseconds, $labelValues);
    }

    /**
     * Get metric family samples
     *
     * @return \Prometheus\MetricFamilySamples[]
     */
    public function getMetricFamilySamples()
    {
        return $this->registry->getMetricFamilySamples();
    }
}
