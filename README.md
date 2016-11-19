# laravel-prometheus-exporter

A prometheus exporter for the Laravel web framework.

It tracks latency and request counts by 
request method, route and response code.

## Installation
`composer require tback/laravel-prometheus-exporter`

### Adapters
Then choose from two storage adapters:
APCu is the default option. Redis can also be used.

#### APCu
Ensure apcu (apcu-bc for php7) is installed and enabled.

#### Redis
Ensure php redis is installed and enabled.

By default it looks for a redis server at localhost:6379. The server
can be configured in `config/prometheus_exporter.php`.

### Configuration
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
