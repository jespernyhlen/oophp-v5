<?php

namespace Jen\Dice;

/**
 * Game interface for Dice Game.
 */
class DiceGame
{
    /**
     * @var player $player          Player object, representing the user.
     * @var AI $AI                  AI object, representing computer opponent.
     * @var int $playerScore        User player score.
     * @var int $AIScore            AI player score.
     * @var array $playerGraphic    Array containing strings representing dice-graphics (css classnames).
     * @var array $AIGraphic        Array containing strings representing dice-graphics (css classnames).
     * @var bool $roundFinished     Boolean to see if a round just finished.
     */
    private $player;
    private $AI;
    private $playerScore;
    private $AIScore;
    private $playerGraphic;
    private $AIGraphic;
    private $roundFinished;

    /**
     * Constructor to initiate the game with a number of dices.
     *
     * @param int $dices - Number of dices for each player.
     */
    public function __construct(int $dices = 2)
    {
        $this->player           = new DicePlayer($dices);
        $this->AI               = new DiceAI($dices);
        $this->playerScore      = 0;
        $this->AIScore          = 0;
        $this->playerGraphic    = [];
        $this->AIGraphic        = [];
        $this->roundFinished    = false;
    }

    /**
     * Reset (players) for new round.
     *
     * @return void.
     */
    public function startRound() : void
    {
        $this->player->init();
        $this->AI->init();
        $this->playerGraphic = [];
        $this->AIGraphic = [];
        $this->roundFinished = false;
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
            $this->AIRoll();
        }
        $this->playerGraphic = $this->player->graphics();
    }

    /**
     * Roll dices for AI (computer).
     * Update totalscore and graphic.
     *
     * @return void
     */
    public function AIRoll() : void
    {
        $this->AI->roll();
        $this->AIGraphic = $this->AI->graphics();
        $this->updateTotal();
    }

    /**
     * Update Total scores based on roundscore from each player.
     * Set round as finished.
     *
     * @return void
     */
    public function updateTotal() : void
    {
        $this->playerScore += $this->player->score();
        $this->AIScore += $this->AI->score();
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
     * Return AI object (computer player).
     *
     * @return AI.
     */
    public function AI()
    {
        return $this->AI;
    }

    /**
     * Return score of player.
     *
     * @return int.
     */
    public function playerScore()
    {
        return $this->playerScore;
    }

    /**
     * Return score of AI (computer player).
     *
     * @return int
     */
    public function AIScore()
    {
        return $this->AIScore;
    }

    /**
     * Return array of graphic representation of dices (classnames).
     *
     * @return array
     */
    public function playerGraphic() : array
    {
        return $this->playerGraphic;
    }

    /**
     * Return array of graphic representation of dices (classnames).
     *
     * @return array
     */
    public function AIGraphic() : array
    {
        return $this->AIGraphic;
    }

    /**
     * Return true/false if round finished, (both players had it's turn).
     *
     * @return bool if round is finished
     */
    public function roundFinished() : bool
    {
        return $this->roundFinished;
    }
}
