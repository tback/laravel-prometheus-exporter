# laravel-prometheus-exporter

A prometheus exporter for the Laravel and the Lumen web framework.

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

### Laravel
#### Register the ServiceProvider
In `config/app.php`
```
'providers' => [
    ...
    Tback\PrometheusExporter\LpeServiceProvider::class,
];
```

#### Enable the Middleware 
In `app/Http/Kernel.php`
```
protected $middleware = [
    ...
    \Tback\PrometheusExporter\LpeResponseTimeMiddleware::class,
];
```

#### Add an endpoint for the metrics
```
Route::get('metric', \Tback\PrometheusExporter\LpeController::class . '@metrics');
```

### Lumen
#### Register the ServiceProvider
In `bootstrap/app.php`
```
$app->register(\Tback\PrometheusExporter\LpeServiceProvider::class);
```

#### Enable the Middleware
In `bootstrap/app.php`
```
$app->middleware([
    \Tback\PrometheusExporter\LpeResponseTimeMiddleware::class
]);
```

#### Add an endpoint for the metrics
```
Route::get('metric', \Tback\PrometheusExporter\LpeController::class . '@metrics');
```

## Configuration
The configuration can be found in `config/prometheus_exporter.php`.

| name        | description                                             |
|-------------|---------------------------------------------------------|
| adapter     | Storage adapter to use: 'apc' or 'redis' default: 'apc' |
| namespace   | name (prefix) to use in prometheus metrics. default: 'default' |
| redis       | array of redis parameters. see prometheus_exporter.php for details |

## Usage
```
$manager = app('LpeManager');

$manager->incCounter('NAME', 'HELP', 'NAMESPACE', 'LABELS', 'DATA');

$manager->incByCounter('NAME', 'HELP', 'VALUE', 'NAMESPACE', 'LABELS', 'DATA');
```
