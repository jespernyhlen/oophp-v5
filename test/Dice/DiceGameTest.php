<?php

namespace Jen\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceGame.
 */
class DiceGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Jen\Dice\DiceGame", $diceGame);
        $this->assertInstanceOf("\Jen\Dice\DicePlayer", $diceGame->player());
        // $this->assertInstanceOf("\Jen\Dice\DiceComputer", $diceGame->computer());



        $res = $diceGame->scores();
        $exp = [0, 0];
        $this->assertEquals($exp, $res);

        $res = $diceGame->graphics();
        $exp = [[], []];
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify we get new graphics/values
     * when rolling the dice for player.
     */
    public function testRollDice()
    {
        $diceGame = new DiceGame();

        $diceGame->startRound();
        $diceGame->playerRoll();

        $res = $diceGame->graphics();
        $resPlayer = $res[0];
        $exp = [];
        $this->assertNotEquals($exp, $resPlayer);
    }

    /**
     * Construct object and verify we get new graphics/values
     * when rolling the dice for computer.
     */
    public function testRollDiceComputer()
    {
        $diceGame = new DiceGame();

        $diceGame->startRound();
        $diceGame->computerRoll();

        $res = $diceGame->graphics();
        $resComputer= $res[1];
        $exp = [];
        $this->assertNotEquals($exp, $resComputer);
    }

    /**
     * Test that we can restart a round after computer rolled the dice
     */
    public function testStartRound()
    {
        $diceGame = new DiceGame();

        $diceGame->startRound();
        $diceGame->computerRoll();

        $res = $diceGame->graphics();
        $exp = [[], []];
        $this->assertNotEquals($exp, $res);

        $diceGame->startRound();

        $res = $diceGame->graphics();
        $exp = [[], []];
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify we get new graphics/values
     * when rolling the dice.
     */
    public function testShowWinner()
    {
        $diceGame = new DiceGame();

        $res = $diceGame->showWinner(120, 50);
        $exp = "You won, congratulations!!";
        $this->assertEquals($exp, $res);

        $res = $diceGame->showWinner(99, 100);
        $exp = "Too bad, the computer won this one!!";
        $this->assertEquals($exp, $res);

        $res = $diceGame->showWinner(101, 102);
        $exp = "Both made it to 100!";
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify we get new histogram print get right value
     * when rolling the dice.
     */
    public function testPrintHistogram()
    {
        $diceGame = new DiceGame();

        //First player
        $res = $diceGame->PrintHistogram()[0];
        $exp = "";
        $this->assertEquals($exp, $res);

        //Computer player
        $res = $diceGame->PrintHistogram()[1];
        $exp = "";
        $this->assertEquals($exp, $res);

        $diceGame->startRound();

        //First player
        $diceGame->playerRoll();
        $res = $diceGame->PrintHistogram()[0];
        $exp = 0;
        $this->assertNotEquals($exp, strlen($res));
        $this->assertInternalType("string", $res);

        //Computer player
        $diceGame->computerRoll();
        $res = $diceGame->PrintHistogram()[1];
        $exp = 0;
        $this->assertNotEquals($exp, strlen($res));
        $this->assertInternalType("string", $res);
    }

    /**
     * Check that a player/computer object creates
     *
     */
    public function testGetPlayer()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Jen\Dice\DicePlayer", $diceGame->player());
        $this->assertInstanceOf("\Jen\Dice\DicePlayer", $diceGame->computer());
    }
}
