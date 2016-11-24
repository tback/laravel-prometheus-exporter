<?php
namespace Tback\PrometheusExporter;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Prometheus\RenderTextFormat;

/**
 * Class LpeController
 * @package Tback\PrometheusExporter
 */
class LpeController extends Controller
{
    /**
     * @var LpeManager
     */
    protected $lpeManager;
    /**
     * LpeController constructor.
     *
     * @param LpeManager $lpeManager
     */
    public function __construct(LpeManager $lpeManager)
    {
        $this->lpeManager = $lpeManager;
    }

    /**
     * metric
     *
     * Expose metrics for prometheus
     *
     * @return Response
     */
    public function metrics()
    {
        $renderer = new RenderTextFormat();

        return response($renderer->render($this->lpeManager->getMetricFamilySamples()))
            ->header('Content-Type', $renderer::MIME_TYPE);
    }
}
