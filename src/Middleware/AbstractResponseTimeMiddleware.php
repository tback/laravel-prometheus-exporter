<?php
namespace Tback\PrometheusExporter\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tback\PrometheusExporter\LpeManager;

/**
 * Class AbstractResponseTimeMiddleware
 * @package Tback\PrometheusExporter
 */
abstract class AbstractResponseTimeMiddleware
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);
        $this->request = $request;

        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);
        $duration = microtime(true) - $start;

        $label_keys = ['route', 'request_method', 'status_code'];
        $route_name = $this->getRouteName();

        $label_values = [
            $route_name,
            $request->method(),
            $response->status()
        ];

        /** @var LpeManager $manager */
        $manager = app('LpeManager');

        // requests total
        $manager->incCounter(
            'requests_total',
            'number of http requests',
            config('prometheus_exporter.namespace_http_server'),
            $label_keys,
            $label_values
        );

        // request duration
        $manager->incByCounter(
            'requests_latency_milliseconds',
            'duration of http_requests',
            $duration * 1000.0,
            config('prometheus_exporter.namespace_http_server'),
            $label_keys,
            $label_values
        );

        return $response;
    }

    /**
     * Get route name
     *
     * @return string
     */
    abstract protected function getRouteName();
}
