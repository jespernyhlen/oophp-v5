<?php

namespace Jen\Dice;

/**
 * A dicehand holding a certain amount of dices.
 */
class DiceHand
{
    /**
     * @var dices $dices        Array containing dices (objects).
     * @var int $diceAmount     Int representing amount of dices in this hand.
     * @var int $values         Array containing dice values.
     * @var int $graphic        Array containing strings representing dice-graphics (css classnames).
     */
    private $dices;
    private $diceAmount;
    private $values;
    private $graphic;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices - Number of dices for each player.
     */
    public function __construct(int $dices = 2)
    {
        $this->diceAmount = $dices;
        $this->init();
    }

    /**
     * initiate the dicehand.
     *
     * @return void.
     */
    public function init() : void
    {
        $this->dices  = [];
        $this->values = [];
        $this->graphic = [];

        for ($i = 0; $i < $this->diceAmount; $i++) {
            $this->dices[]  = new Dice();
            $this->values[] = null;
            $this->graphic[] = null;
        }
    }

    /**
     * Roll all dices and save their value/graphic.
     *
     * @return void.
     */
    public function roll() : void
    {
        for ($i = 0; $i < sizeof($this->dices); $i++) {
            $this->values[$i] = $this->dices[$i]->roll();
            $this->graphic[$i] = $this->dices[$i]->graphic();
        }
    }

    /**
     * Return array of all dice values.
     *
     * @return array with values.
     */
    public function values() : array
    {
        return $this->values;
    }

    /**
     * Return array of all dice graphics.
     *
     * @return array as representation of last rolled dices.
    */
    public function graphic() : array
    {
        $diceGraphics = [];

        for ($i = 0; $i < sizeof($this->dices); $i++) {
            $diceGraphics[] = $this->dices[$i]->graphic();
        }
        return $diceGraphics;
    }
}
