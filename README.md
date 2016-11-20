# laravel-prometheus-exporter

A prometheus exporter for the Laravel web framework.

It tracks latency and request counts by 
request method, route and response code.

By default the app will then exporter prometheus metrics on `/metrics`.

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

### Register the ServiceProvider
In `config/app.php`
```
'providers' => [
    ...
    Tback\PrometheusExporter\ServiceProvider::class,
];
```

### Enable the Middleware 
In `app/Http/Kernel.php`
```
protected $middleware = [
    ...
    \Tback\PrometheusExporter\Middleware::class,
];
```

## Configuration
The configuration can be found in `config/prometheus_exporter.php`.

| name        | description                                             |
|-------------|---------------------------------------------------------|
| adapter     | Storage adapter to use: 'apc' or 'redis' default: 'apc' |
| metrics_path| Where to reach metrics. default: '/metrics'             |
| name        | name (prefix) to use in prometheus metrics. default: 'http_server' |
| redis       | array of redis parameters. see prometheus_exporter.php for details |
