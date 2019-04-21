<?php

namespace Jen\Dice;

/**
 * A class to simulate a Dice.
 */
class Dice
{
    /**
     * @var int $sides      Number of sides for a dice.
     * @var int $lastRoll   Value of last rolled dice.
     */
    private $sides;
    private $lastRoll;

    /**
     * Constructor to initiate the dice with a number of sides.
     *
     * @param int $sides Number of sides for a dice, defaults to six.
     */
    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
        $this->roll();
    }

    /**
     * Randomize the dicenumber and return last rolled dice.
     *
     * @return int
     */
    public function roll() : int
    {
        $this->lastRoll = rand(1, $this->sides);
        return $this->lastRoll;
    }

    /**
     * Return last rolled dice.
     *
     * @return int
     */
    public function getLastRoll() : int
    {
        return $this->lastRoll;
    }

    /**
     * Get string to use as classname, to simulate a dice.
     *
     * @return string as representation of last rolled dice.
    */
    public function graphic() : string
    {
        return "dice-" . $this->getLastRoll();
    }
}
