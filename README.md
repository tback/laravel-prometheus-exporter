# laravel-prometheus-exporter

A prometheus exporter for the Laravel web framework.

## Installation
First make sure apcu (apcu-bc for php7) is installed.

`composer require tback/laravel-prometheus-exporter`

In `app/Http/Kernel.php`
```
protected $middleware = [
    ...
    \Tback\PrometheusExporter\Middleware::class,
];
```

In `config/app.php`
```
'providers' => [
    ...
    Tback\PrometheusExporter\ServiceProvider::class,
];
```

Your app will now export metrics on /metrics.
