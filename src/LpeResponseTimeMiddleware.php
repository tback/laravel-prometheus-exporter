<?php
namespace Tback\PrometheusExporter;

use Closure;
use Illuminate\Http\Request;

/**
 * Class LpeResponseTimeMiddleware
 * @package Tback\PrometheusExporter
 */
class LpeResponseTimeMiddleware
{
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

        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);
        $duration = microtime(true) - $start;

        $label_keys = ['uri', 'request_method', 'status_code'];
        $label_values = [
            $request->route()[1]['uri'],
            $request->method(),
            $response->status()
        ];

        /** @var LpeManager $manager */
        $manager = app('LpeManager');

        // requests total
        $manager->incCounter(
            'requests_total',
            'number of http requests',
            null,
            $label_keys,
            $label_values
        );

        // request duration
        $manager->incByCounter(
            'requests_latency_milliseconds',
            'duration of http_requests',
            $duration * 1000.0,
            null,
            $label_keys,
            $label_values
        );

        return $response;
    }
}
