<?php

namespace Jen\Dice;

/**
 * A trait to use for histogram.
 */
trait HistogramTrait
{
    /**
     * @var array $serie  Histogram serie values.
     */
    private $serie = [];

    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }



    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin()
    {
        return 1;
    }



    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax()
    {
        return max($this->serie);
    }
}
