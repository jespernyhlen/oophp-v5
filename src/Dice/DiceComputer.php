<?php

namespace Jen\Dice;

/**
 * Extended DicePlayer class to act as a Computer player.
 */
class DiceComputer extends DicePlayer
{
    /**
     * Roll dices a random amount of times - end if a dice is one.
     * Update score and graphic representation.
     *
     * @return void.
     */
    public function roll() : void
    {
        $timesToRoll = rand(1, 3);

        for ($i=0; $i < $timesToRoll; $i++) {
            $this->diceHand->roll();
            $this->graphics = array_merge($this->graphics, $this->diceHand->graphic());
            $diceValues = $this->updatescore();
            if (in_array(1, $diceValues)) {
                break;
            }
        }
    }
}
