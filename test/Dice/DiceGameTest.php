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
        $this->assertInstanceOf("\Jen\Dice\DiceComputer", $diceGame->computer());



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
     * Chech that we got right true return if a player got
     * more then 100 points, else false.
     */
    public function testGotWinner()
    {
        $diceGame = new DiceGame();

        $res = $diceGame->gotWinner(50, 50);
        $exp = false;
        $this->assertEquals($exp, $res);

        $res = $diceGame->gotWinner(100, 50);
        $exp = true;
        $this->assertEquals($exp, $res);

        $res = $diceGame->gotWinner(120, 0);
        $exp = true;
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
        $exp = "You won, congratiulations!!";
        $this->assertEquals($exp, $res);

        $res = $diceGame->showWinner(99, 100);
        $exp = "The computer won this game!!";
        $this->assertEquals($exp, $res);

        $res = $diceGame->showWinner(101, 102);
        $exp = "Both made it to 100!";
        $this->assertEquals($exp, $res);
    }
}
