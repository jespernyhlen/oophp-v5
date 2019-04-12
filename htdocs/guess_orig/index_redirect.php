<?php
/**
 * Guess the number.
 */

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";
require __DIR__ . "/src/GuessException.php";




/**
 * A processing page that does a redirect.
 */
if ($_POST["posted"]) {
    // Incoming variables
    $_SESSION["guess"]   = $_POST["guess"] ?? null;
    $_SESSION["doInit"]  = $_POST["doInit"] ?? null;
    $_SESSION["doGuess"] = $_POST["doGuess"] ?? null;
    $_SESSION["doCheat"] = $_POST["doCheat"] ?? null;
}
// <pre>
// <?= var_dump($_SESSION)

$url = "index.php";
header("Location: $url");
