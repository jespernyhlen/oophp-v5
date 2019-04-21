<?php

namespace Jen\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DicePlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dicePlayer = new DicePlayer();
        $this->assertInstanceOf("\Jen\Dice\DicePlayer", $dicePlayer);

        $res = $dicePlayer->score();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test to update values for player with no values
     */
    public function testUpdateScoreNoValues()
    {
        $dicePlayer = new DicePlayer();

        $res = $dicePlayer->updateScore();
        $exp = [null, null];
        $this->assertEquals($exp, $res);
    }

    /**
     * Test to update values for player with  values
     */
    public function testUpdateScoreWithValues()
    {
        $dicePlayer = new DicePlayer();
        $dicePlayer->roll();

        $res = $dicePlayer->updateScore();
        $exp = [null, null];
        $this->assertNotEquals($exp, $res);

        $valueOne = $res[0];
        $this->assertInternalType("integer", $valueOne);
    }
}
