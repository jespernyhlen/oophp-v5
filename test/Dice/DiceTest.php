<?php

namespace Jen\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceTest extends TestCase
{
    /**
     * Check that a int number is return when rolling dice
     *
     */
    public function testRollDice()
    {
        $dice = new Dice();

        $res = $dice->getLastRoll();
        $this->assertInternalType("int", $res);
    }

    /**
     * Check output of dicegraphic equals to a string, with substring "dice-".
     *
     */
    public function testDiceGraphic()
    {
        $dice = new Dice();

        $res = $dice->graphic();
        $this->assertInternalType("string", $res);

        $graphicPrefix = substr($res, 0, 5);
        $this->assertEquals("dice-", $graphicPrefix);
    }

    public function testCreateObjectWithValue()
    {
        $dice = new Dice(1);

        $res = $dice->getLastRoll();
        $exp = 1;
        $this->assertEquals($exp, $res);

        $dice->roll();

        $res = $dice->getLastRoll();
        $exp = 1;
        $this->assertEquals($exp, $res);

        $dice->roll();

        $res = $dice->getLastRoll();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }
}
