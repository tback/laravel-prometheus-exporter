<?php

return [
    /*
     * possible values are apc or redis
     */
    'adapter' => env('PROMETHEUS_ADAPTER', 'apc'),

    'namespace' => 'app',

    'namespace_http_server' => 'http_server',

    /*
     * HTTP Methods. List aquired from
     * https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
     * Enable the ones that are in use by your application.
     */
    'init_metrics_for_http_methods' => [
        'GET',
        'HEAD',
        'POST',
        //'PUT',
        //'DELETE',
        //'CONNECT',
        //'OPTIONS',
        //'TRACE',
        //'PATCH'
    ],

    /*
     * HTTP Status codes. List aquired from
     * https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
     * Enable the ones that are in use by your application.
     */
    'init_metrics_for_http_status_codes' => [
        //100, //Continue
        //101, //Switching Protocols
        //102, //Processing
        //103, //Early Hints
        200, //OK
        201, //Created
        //202, //Accepted
        //203, //Non-Authoritative Information
        //204, //No Content
        //205, //Reset Content
        //206, //Partial Content
        //207, //Multi-Status
        //208, //Already Reported
        //226, //IM Used
        //300, //MultipleChoices
        //301, //MovedPermanently
        //302, //Found
        //303, //Not Modified
        //305, //Use Proxy
        //307, //Temporary Redirect
        //308, //Permanent Redirect
        //400, //Bad Request
        401, //Unauthorized
        //402, //Payment Required
        //403, //Forbidden
        404, //Not Found
        //405, //Method not allowed
        //406, //Not Acceptable
        //407, //Proxy Authentication required
        //409, //Conflict
        //410, //Gone
        //411, //Length required
        //412, //Precondition failed
        //413, //Payload too large
        //414, //URI too long
        //415, //Unsupported media type
        //416, //Range not satisfiable
        //417, //Expectation failed
        //418, //I'm a teapot
        //421, //Misdirected request
        //422, //Unprocessable Entity
        //423, //Locked
        //424, //Failed dependency
        //426, //Upgrade required
        //428, //Precondition required
        //429, //Too many requests
        //431, //Request header fields too large
        //451, //Unavailable for legal reasons
        500, //Internal Server Error
        //501, //Not Implemented
        //502, //Bad Gateway
        //503, //Service Unavailable
        //504, //Gateway Timeout
        //505, //HTTP Version Not Supported
        //506, //Variant also negotiates
        //507, //Insufficient Storage
        //508, //Loop detected
        //510, //Not Extended
        //511, //Network Authentication Required
    ],

        'redis' => [
        'host'                   => '127.0.0.1',
        'port'                   => 6379,
        'timeout'                => 0.1,  // in seconds
        'read_timeout'           => 10, // in seconds
        'persistent_connections' => false,
    ],
];
