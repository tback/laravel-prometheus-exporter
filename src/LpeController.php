<?php
namespace Tback\PrometheusExporter;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Prometheus\RenderTextFormat;

/**
 * Class LpeController
 * @package Tback\PrometheusExporter
 */
class LpeController extends Controller
{
    /**
     * metric
     *
     * Expose metrics for prometheus
     *
     * @return Response
     */
    public function metrics()
    {
        $manager = app('LpeManager');

        $renderer = new RenderTextFormat();

        return response($renderer->render($manager->getMetricFamilySamples()))
            ->header('Content-Type', $renderer::MIME_TYPE);
    }
}
