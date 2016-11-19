<?php

namespace Tback\PrometheusExporter;

use Closure;
use Illuminate\Http\Request;

class Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $start = time();
        $response = $next($request);
        $duration = time() - $start;

        $registry = app('prometheus');
        $request_counter = $registry->registerCounter('http_server', 'requests_total', 'number of http requests',
            ['uri', 'request_method', 'status_code']);
        $request_duration = $registry->registerCounter('http_server', 'requests_latency_milliseconds', 'duration of http_equests',
            ['uri', 'request_method', 'status_code']);

        $route = $request->route();

        $labels = [$route ? $route->uri() : '-', $request->method(), $response->status()];
        $request_counter->inc($labels);
        $request_duration->incBy($duration * 1000.0, $labels);

        return $response;
    }
}
