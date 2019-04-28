<?php

namespace Jen\Dice;

/**
 * A player consisting of a dice hand.
 */
class DicePlayer
{
    /**
    * @var diceHand $diceHand     Dice hand object, representing a hand of dices.
    * @var int $dices             Number of dices a player got.
    * @var int $score             Number representing players current score.
    * @var array $graphics        Array containing strings representing dice-graphics (css classnames).
    */
    protected $diceHand;
    protected $dices;
    protected $score;
    protected $graphics;

    /**
    * Constructor to initiate the diceplayer
    *
    * @param int $dices - Number of dices for player.
    */
    public function __construct(int $dices = 2)
    {
        $this->dices = $dices;
        $this->init();
        $this->diceHand = new DiceHand($this->dices);
    }

    /**
    * Initiate player object.
    *
    * @return void
    */
    public function init() : void
    {
        $this->score = 0;
        $this->graphics = [];
    }

    /**
    * Roll all dices in the dicehand.
    * Update and dicegraphic for player.
    *
    * @return void.
    */
    public function roll() : void
    {
        $this->diceHand->roll();
        $this->graphics = array_merge($this->graphics, $this->diceHand->graphic());
    }

    /**
    * Update players score based on dicehand.
    * Return dicevalues.
    *
    * @return array.
    */
    public function updateScore() : array
    {
        $diceValues = $this->diceHand->values();
        if (in_array(1, $diceValues)) {
            $this->score = 0;
        } else {
            $this->score += array_sum($diceValues);
        }
        return $diceValues;
    }

    /**
    * Return current score of player.
    *
    * @return int $score
    */
    public function score()
    {
        return $this->score;
    }

    /**
    * Return array with current dicegraphic of player.
    *
    * @return array $graphics
    */
    public function graphics() : array
    {
        return $this->graphics;
    }

    /**
    * Return array with current dicegraphic of player.
    *
    * @return object $graphics
    */
    public function diceHand() : object
    {
        return $this->diceHand;
    }
}
