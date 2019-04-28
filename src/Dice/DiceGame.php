<?php

namespace Jen\Dice;

/**
 * Game interface for Dice Game.
 */
 class DiceGame
// class DiceGame implements HistogramInterface
{
    // use HistogramTrait;
    /**
     * @var player $player              Player object, representing the user.
     * @var computer $computer          computer object, representing computer opponent.
     * @var int $playerRoundScore       Roundscore player.
     * @var int $computerRoundScore     Roundscore computer.
     * @var int $playerScore            User player score.
     * @var int $computerScore          computer player score.
     * @var array $playerGraphic        Array containing strings representing dice-graphics (css classnames).
     * @var array $computerGraphic      Array containing strings representing dice-graphics (css classnames).
     * @var bool $roundFinished         Boolean to see if a round just finished.
     * @var playerHistogram $playerHistogram        Histogram object to store histogram data.
     * @var computerHistogram $computerHistogram    Histogram object to store histogram data.

     */
    private $player;
    private $playerScore;
    private $playerRoundScore;
    private $playerGraphic;
    private $playerHistogram;

    private $computer;
    private $computerScore;
    private $computerRoundScore;
    private $computerGraphic;
    private $computerHistogram;

    private $roundFinished;




    /**
     * Constructor to initiate the game with a number of dices.
     *
     * @param int $dices - Number of dices for each player.
     */
    public function __construct(int $dices = 2)
    {
        $this->player               = new DicePlayer($dices);
        $this->playerScore          = 0;
        $this->playerGraphic        = [];
        $this->playerRoundScore     = 0;
        $this->playerHistogram      = new Histogram;

        $this->computer             = new DicePlayer($dices);
        $this->computerScore        = 0;
        $this->computerGraphic      = [];
        $this->computerRoundScore   = 0;
        $this->computerHistogram    = new Histogram;

        $this->roundFinished        = false;


    }

    /**
     * Reset necessery values for a new round.
     *
     * @return void.
     */
    public function startRound() : void
    {
        if ($this->roundFinished()) {
            $this->player->init();
            $this->playerGraphic = [];
            $this->playerRoundScore = 0;

            $this->computer->init();
            $this->computerGraphic = [];
            $this->computerRoundScore = 0;

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
        $diceValues = $this->player->diceHand()->values();
        $this->playerRoundScore += array_sum($diceValues);

        $this->player->updateScore();
        if (in_array(1, $diceValues)) {
            $this->computerRoll();
        }
        $this->playerGraphic = $this->player->graphics();
        $this->playerHistogram->injectData($this->player->diceHand());

    }

    /**
     * Roll dices for computer (computer).
     * Roll/stop is based on players/computers scores.
     * Update totalscore and graphic.
     *
     * @return void
     */
    public function computerRoll() : void
    {
        $rolling = true;

        while ($rolling) {
            $this->computer->roll();
            $diceValues = $this->computer->diceHand()->values();
            $this->computerRoundScore += array_sum($diceValues);
            $this->computer->updatescore();
            $this->computerGraphic = $this->computer->graphics();
            $this->computerHistogram->injectData($this->computer->diceHand());

            if (in_array(1, $diceValues)) {
                break;
            }
            $rolling = $this->computerIntelligence();
        }
        $this->updateTotal();
    }


    /**
     * Roll dices for computer (computer).
     * Roll/stop is based on players/computers scores.
     * Update totalscore and graphic.
     *
     * @return array
     */
    public function printHistogram() : array
    {
        $playerHistogram = $this->playerHistogram->getAsText();
        $computerHistogram = $this->computerHistogram->getAsText();

        return [
            $playerHistogram,
            $computerHistogram
        ];
    }

    /**
     * Check if computer keep rolling or save round score,
     * Based on player and computer current scores.
     *
     * @return bool
     */
    private function computerIntelligence() : bool
    {
        $roll = false;
        $computerScoreTotal = $this->computerScore + $this->computerRoundScore;
        $computerBankedScore = $this->computerScore;
        $computerRoundScore = $this->computerRoundScore;
        $playerScoreTotal = $this->playerScore + $this->playerRoundScore;

        if ($computerRoundScore < 20) {
            $roll = true;
        }

        if (($playerScoreTotal - $computerScoreTotal) > 30) {
            $roll = true;
        }

        if (($computerScoreTotal) > 90
            || $playerScoreTotal > 90) {
            $roll = true;
        }

        if (($computerScoreTotal) > 100) {
            $roll = false;
        }

        return $roll;
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
        $winner = false;
        if ($firstScore < 100 && $secondScore < 100) {
            return $winner;
        }
        return true;
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
            $message = "You won, congratulations!!";
        } else {
            $message = "Too bad, the computer won this one!!";
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
