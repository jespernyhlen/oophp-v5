<?php

namespace Jen\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Histogram.
 */
class HistogramTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("\Jen\Dice\Histogram", $histogram);

        $res = $histogram->getSerie();
        $exp = [];
        $this->assertEquals($exp, $res);

        $res = $histogram->getAsText();
        $exp = "";
        $this->assertEquals($exp, $res);
    }

    /**
     * Test to create an object using HistogramInterface.
     * Then create a Histogram to inject data into.
     */
    public function testInjectData()
    {
        $histogram = new Histogram();
        $diceHand = new DiceHand;

        $diceHand->roll();
        $histogram->injectData($diceHand);

        $res = $histogram->getAsText();
        $exp = "";

        $this->assertNotEquals($exp, $res);
        $this->assertInternalType("string", $res);

        $res = $histogram->getSerie();
        $exp = [];

        $this->assertNotEquals($exp, $res);
        $this->assertInternalType("array", $res);
    }
}
