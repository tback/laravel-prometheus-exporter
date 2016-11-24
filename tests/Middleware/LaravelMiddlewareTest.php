<?php


use Prometheus\CollectorRegistry;

class LaravelMiddlewareTest extends Orchestra\Testbench\TestCase
{
    public function testLaravelResponseTimeMiddleware()
    {
        $lpeManager = new \Tback\PrometheusExporter\LpeManager(new CollectorRegistry(new \Prometheus\Storage\InMemory()));
        $middleware = new \Tback\PrometheusExporter\Middleware\LaravelResponseTimeMiddleware($lpeManager);
        $middleware->handle(new \Illuminate\Http\Request(), function(){
            return new \Illuminate\Http\Response();
        });
    }
}
