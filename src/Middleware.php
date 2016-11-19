<?php

namespace Tback\PrometheusExporter;

use Closure;
use Illuminate\Http\Request;

class Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);
        $response = $next($request);
        $duration = microtime(true) - $start;

        $registry = app('prometheus');
        $name = config('prometheus_exporter.name');

        $label_keys = ['uri', 'request_method', 'status_code'];
        $request_counter = $registry->registerCounter(
            $name, 'requests_total', 'number of http requests', $label_keys);
        $request_duration = $registry->registerCounter($name, 'requests_latency_milliseconds',
            'duration of http_equests',
            $label_keys);

        $route = $request->route();

        $label_values = [$route ? $route->uri() : '-', $request->method(), $response->status()];
        $request_counter->inc($label_values);
        $request_duration->incBy($duration * 1000.0, $label_values);

        return $response;
    }
}
