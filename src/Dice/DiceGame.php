<?php

namespace Jen\Dice;

/**
 * Game interface for Dice Game.
 */
class DiceGame
{
    /**
     * @var player $player          Player object, representing the user.
     * @var computer $computer      computer object, representing computer opponent.
     * @var int $playerScore        User player score.
     * @var int $computerScore      computer player score.
     * @var array $playerGraphic    Array containing strings representing dice-graphics (css classnames).
     * @var array $computerGraphic  Array containing strings representing dice-graphics (css classnames).
     * @var bool $roundFinished     Boolean to see if a round just finished.
     */
    private $player;
    private $computer;
    private $playerScore;
    private $computerScore;
    private $playerGraphic;
    private $computerGraphic;
    private $roundFinished;

    /**
     * Constructor to initiate the game with a number of dices.
     *
     * @param int $dices - Number of dices for each player.
     */
    public function __construct(int $dices = 2)
    {
        $this->player           = new DicePlayer($dices);
        $this->computer         = new DiceComputer($dices);
        $this->playerScore      = 0;
        $this->computerScore    = 0;
        $this->playerGraphic    = [];
        $this->computerGraphic  = [];
        $this->roundFinished    = false;
    }

    /**
     * Reset (players) for new round.
     *
     * @return void.
     */
    public function startRound() : void
    {
        if ($this->roundFinished()) {
            $this->player->init();
            $this->computer->init();
            $this->playerGraphic = [];
            $this->computerGraphic = [];
            $this->roundFinished = false;
        }
    }

    /**
     * Roll dices for player.
     * Update roundscore for player and graphic.
     *
     * @return void.
     */
    public function playerRoll() : void
    {
        $this->player->roll();
        $diceValues = $this->player->updateScore();
        if (in_array(1, $diceValues)) {
            $this->computerRoll();
        }
        $this->playerGraphic = $this->player->graphics();
    }

    /**
     * Roll dices for computer (computer).
     * Update totalscore and graphic.
     *
     * @return void
     */
    public function computerRoll() : void
    {
        $this->computer->roll();
        $this->computerGraphic = $this->computer->graphics();
        $this->updateTotal();
    }

    /**
     * Update Total scores based on roundscore from each player.
     * Set round as finished.
     *
     * @return void
     */
    private function updateTotal() : void
    {
        $this->playerScore += $this->player->score();
        $this->computerScore += $this->computer->score();
        $this->roundFinished = true;
    }

    /**
     * Return true if a player got more then 100 points, else false.
     *
     * @return bool
     */
    public function gotWinner(int $firstScore, int $secondScore): bool
    {
        if ($firstScore < 100 && $secondScore < 100) {
            return false;
        } elseif ($firstScore >= 100 || $secondScore >= 100) {
            return true;
        }
    }

    /**
     * Return string based on winner of the game.
     *
     * @return string
     */
    public function showWinner(int $firstScore, int $secondScore) : string
    {
        $message = "";
        if ($firstScore >= 100 && $secondScore >= 100) {
            $message = "Both made it to 100!";
        } elseif ($firstScore >= 100) {
            $message = "You won, congratiulations!!";
        } else {
            $message = "The computer won this game!!";
        }
        return $message;
    }

    /**
     * Return player object.
     *
     * @return player.
     */
    public function player()
    {
        return $this->player;
    }

    /**
     * Return computer object (computer player).
     *
     * @return computer.
     */
    public function computer()
    {
        return $this->computer;
    }

    /**
     * Return array witch score of player/computer.
     *
     * @return array
     */
    public function scores() : array
    {
        return [$this->playerScore, $this->computerScore];
    }

    /**
     * Return array of graphic representation of dices (classnames).
     *
     * @return array
     */
    public function graphics() : array
    {
        return [$this->playerGraphic, $this->computerGraphic];
    }

    /**
     * Return true/false if round finished, (both players had it's turn).
     *
     * @return bool if round is finished
     */
    private function roundFinished() : bool
    {
        return $this->roundFinished;
    }
}
