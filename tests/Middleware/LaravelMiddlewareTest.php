<?php


class LaravelMiddlewareTest extends Orchestra\Testbench\TestCase
{
    public function testLaravelResponseTimeMiddleware()
    {
        $middleware = new \Tback\PrometheusExporter\Middleware\LaravelResponseTimeMiddleware();
        $middleware->handle(new \Illuminate\Http\Request(), function(){
            return new \Illuminate\Http\Response();
        });
    }
}
