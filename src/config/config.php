<?php

return [
    /*
     * possible values are apc or redis
     */
    'adapter' => env('PROMETHEUS_ADAPTER', 'apc'),

    'namespace' => 'default',

    'redis' => [
        'host'                   => '127.0.0.1',
        'port'                   => 6379,
        'timeout'                => 0.1,  // in seconds
        'read_timeout'           => 10, // in seconds
        'persistent_connections' => false,
    ],
];
