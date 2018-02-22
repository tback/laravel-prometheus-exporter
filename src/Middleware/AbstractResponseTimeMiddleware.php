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
     * @var LpeManager
     */
    protected $lpeManager;

    /**
     * AbstractResponseTimeMiddleware constructor.
     *
     * @param LpeManager $lpeManager
     */
    public function __construct(LpeManager $lpeManager)
    {
        $this->lpeManager = $lpeManager;
    }

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
        $duration_milliseconds = $duration * 1000.0;

        $route_name = $this->getRouteName();
        $method = $request->getMethod();
        $status = $response->getStatusCode();

        $this->lpeManager->countRequest($route_name, $method, $status, $duration_milliseconds);

        return $response;
    }

    /**
     * Get route name
     *
     * @return string
     */
    abstract protected function getRouteName();
}
