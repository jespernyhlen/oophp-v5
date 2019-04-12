<?php
/**
 * Guess the number.
 */

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";
require __DIR__ . "/src/GuessException.php";



// Incoming variables
$guess   = $_SESSION["guess"] ?? null;
$doInit  = $_SESSION["doInit"] ?? null;
$doGuess = $_SESSION["doGuess"] ?? null;
$doCheat = $_SESSION["doCheat"] ?? null;
$number  = $_SESSION["number"] ?? null;
$tries   = $_SESSION["tries"] ?? null;
$res = null;


if ($doInit || $number === null) {
    // Init game
    $guessGame = new Guess;
    $_SESSION["number"] = $guessGame->number();
    $_SESSION["tries"] = $guessGame->tries();
} elseif ($doGuess) {
    // Play game, make a guess
    $guessGame = new Guess($number, $tries);
    try {
        $res = $guessGame->makeGuess($guess);
    } catch (TypeError $e) {
        echo 'YOUR GUESS CAN NOT BE A EMPTY FIELD';
    }
    $_SESSION["tries"] = $guessGame->tries();
}

$tries = $_SESSION["tries"];

require __DIR__ . "/view/header.php";
require __DIR__ . "/view/guess_number.php";
?>
<!-- <pre>
<?= var_dump($_SESSION) ?> -->
