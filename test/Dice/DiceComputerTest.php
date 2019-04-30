<?php
//
// namespace Jen\Dice;
//
// use PHPUnit\Framework\TestCase;
//
// /**
//  * Test cases for class DiceHand.
//  */
// class DiceComputerTest extends TestCase
// {
//     /**
//      * Construct object and verify that the object has the expected
//      * properties. Use no arguments.
//      */
//     public function testCreateObjectNoArguments()
//     {
//         $diceComputer = new DiceComputer();
//         $this->assertInstanceOf("\Jen\Dice\DiceComputer", $diceComputer);
//
//         $res = $diceComputer->score();
//         $exp = 0;
//         $this->assertEquals($exp, $res);
//     }
//
//     /**
//      * Test to update values for player with no values
//      */
//     public function testUpdateScoreNoValues()
//     {
//         $diceComputer = new DiceComputer();
//
//         $res = $diceComputer->updateScore();
//         $exp = [null, null];
//         $this->assertEquals($exp, $res);
//     }
//
//     /**
//      * Test to update values for player with values
//      */
//     public function testUpdateScoreWithValues()
//     {
//         $diceComputer = new DiceComputer();
//         $diceComputer->roll();
//
//         $res = $diceComputer->updateScore();
//         $exp = [null, null];
//         $this->assertNotEquals($exp, $res);
//
//         $valueOne = $res[0];
//         $this->assertInternalType("integer", $valueOne);
//     }
//
//     /**
//      * Test to roll dice and se score updated
//      */
//     public function testRollDice()
//     {
//         $changedValue = false;
//         $diceComputer = new DiceComputer();
//         for ($i=0; $i < 500; $i++) {
//             $diceComputer->roll();
//             if ($diceComputer->score() != 0) {
//                 $changedValue = true;
//             }
//         }
//         $exp = true;
//         $this->assertEquals($exp, $changedValue);
//     }
// }
