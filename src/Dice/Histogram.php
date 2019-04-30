<?php

namespace Jen\Dice;

/**
 * Histogram class to store histogram data for presentation.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;

    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }

    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Return a string representing the histograms values
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $histoArray = [];
        $histoString = "";

        for ($i = $this->min; $i <= $this->max; $i++) {
            $serieDice = count(array_keys($this->serie, $i));
            array_push($histoArray, $serieDice);
        }

        for ($i = 0; $i < sizeof($histoArray); $i++) {
            if ($i > 0) {
                $histoString .= $i + 1 . ": ";
                for ($k = 0; $k < $histoArray[$i]; $k++) {
                    $histoString .= "*";
                }
                $histoString .=  "<br>";
            }
        }
        return $histoString;
    }
}
