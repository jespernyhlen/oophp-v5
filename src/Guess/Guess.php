<?php

namespace Jen\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of tries a guess has been made.
     * @var bool $correctAnswer    If answer is correct or not.
     */
    private $number;
    private $tries;
    private $correctAnswer = false;




    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $number = -1, int $tries = 6)
    {
        if ($number === -1) {
            $this->random();
        } else {
            $this->number = $number;
        }
        $this->tries = $tries;
    }



    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function random() : void
    {
        $this->number = rand(1, 100);
    }



    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function tries() : int
    {
        return $this->tries;
    }



    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number() : int
    {
        return $this->number;
    }


    /**
     * Check if answer is correct.
     *
     * @return boolean if answer is correct.
     */
    public function correct() : bool
    {
        return $this->correctAnswer;
    }



    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     * @param int $guess is the guessed number.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess(int $guess) : string
    {
        if ($guess < 1 || $guess > 100) {
            throw new GuessException("Number is only allowed to be a integer between 1 and 100.");
        }

        $this->tries -= 1;
        if ($this->tries <= 0 && $guess !== $this->number) {
            $res = "NOT CORRECT! You got no more tries!";
        } elseif ($guess === $this->number) {
            $this->correctAnswer = true;
            $res = "CORRECT!";
        } elseif ($guess > $this->number) {
            $res = "TOO HIGH";
        } else {
            $res = "TOO LOW";
        }
        return $res;
    }
}
