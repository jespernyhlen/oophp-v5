<?php

namespace Jen\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Jen\Dice\DiceHand", $diceHand);

        $res = $diceHand->values();
        $exp = [0, 0];
        $this->assertEquals($exp, $res);

        $res = $diceHand->graphic();
        $this->assertEquals(2, sizeof($res));
    }

    /**
     * Test that values are put in when init the object.
     *
     */
    public function testValuesOnInit()
    {
        $diceHand = new DiceHand();

        $res = $diceHand->values();
        $exp = [0, 0];
        $this->assertEquals($exp, $res);

        $diceHand->roll();

        $res = $diceHand->values();
        $exp = [0, 0];
        $this->assertNotEquals($exp, $res);

        $diceOne = $res[0];
        $diceTwo = $res[1];

        $this->assertInternalType("integer", $diceOne);
        $this->assertInternalType("integer", $diceTwo);
    }

    /**
     * Check output of dicegraphic equals to an array with string, with substring "dice-".
     *
     */
    public function testDiceGraphic()
    {
        $diceHand = new DiceHand();
        $diceHand->roll();

        $res = $diceHand->graphic();
        $this->assertInternalType("array", $res);

        for ($i=0; $i < sizeof($res); $i++) {
            $graphicPrefix = substr($res[$i], 0, 5);
            $this->assertEquals("dice-", $graphicPrefix);
        }
    }
}
