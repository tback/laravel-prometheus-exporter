<?php
namespace Tback\PrometheusExporter;

use Prometheus\CollectorRegistry;

/**
 * Class LpeManager
 *
 * @author Christopher Lorke <lorke@traum-ferienwohnungen.de>
 * @package Tback\PrometheusExporter
 */
class LpeManager
{
    /**
     * @var CollectorRegistry
     */
    protected $registry;

    /**
     * LpeManager constructor.
     * @param CollectorRegistry $registry
     */
    public function __construct(CollectorRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Get metric family samples
     *
     * @return \Prometheus\MetricFamilySamples[]
     */
    public function getMetricFamilySamples()
    {
        return $this->registry->getMetricFamilySamples();
    }

    /**
     * inc
     *
     * @param string $name
     * @param string $help
     * @param string|null $namespace
     * @param array $labels
     * @param array $data
     */
    public function incCounter($name, $help, $namespace = null, array $labels = [], array $data = [])
    {
        if (!$namespace) {
            $namespace = config('prometheus_exporter.namespace');
        }

        $this->registry->registerCounter($namespace, $name, $help, $labels)->inc($data);
    }

    /**
     * incBy
     *
     * @param string $name
     * @param string $help
     * @param string|null $namespace
     * @param array $labels
     * @param float $value
     * @param array $data
     */
    public function incByCounter($name, $help, $value, $namespace = null, array $labels = [], array $data = [])
    {
        if (!$namespace) {
            $namespace = config('prometheus_exporter.namespace');
        }

        $this->registry->registerCounter($namespace, $name, $help, $labels)->incBy($value, $data);
    }
}
