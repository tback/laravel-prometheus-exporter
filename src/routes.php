<?php

use Illuminate\Http\Request;

Route::get('/metrics', function (Request $request) {
    $renderer = new \Prometheus\RenderTextFormat();

    $registry = app('prometheus');

    return response($renderer->render($registry->getMetricFamilySamples()))
        ->header('Content-Type', $renderer::MIME_TYPE);
})->name('metrics');
