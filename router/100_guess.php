<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for gamestart
    $guessGame = new Jen\Guess\Guess;
    $_SESSION["number"] = $guessGame->number();
    $_SESSION["tries"] = $guessGame->tries();

    return $app->response->redirect("guess/play");
});



/**
 * Play the game
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Spela gissa mitt nummer";

    $tries = $_SESSION["tries"] ?? null;
    $res   = $_SESSION["res"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $doCheat = $_SESSION["doCheat"] ?? null;
    $number = $_SESSION["number"] ?? null;

    $_SESSION["res"]   =  null;
    $_SESSION["guess"] =  null;
    $_SESSION["doCheat"]   =  null;

    $data = [
        "guess" => $guess ?? null,
        "number" => $number ?? null,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
        "tries" => $tries,
        "res" => $res,

    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");


    return $app->page->render([
        "title" => $title,
    ]);
});



/**
 * Play the game - Make a guess
 */
$app->router->post("guess/guess_redirect", function () use ($app) {

    $guess   = $_POST["guess"] ?? null;
    $doInit  = $_POST["doInit"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;

    $number  = $_SESSION["number"] ?? null;
    $tries   = $_SESSION["tries"] ?? null;
    $res = null;

    if ($doGuess) {
        // Play game, make a guess
        $guessGame = new Jen\Guess\Guess($number, $tries);
        try {
            $res = $guessGame->makeGuess($guess);
        } catch (TypeError $e) {
        }
        $_SESSION["tries"] = $guessGame->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
    } elseif ($doInit) {
        return $app->response->redirect("guess/init");
    } elseif ($doCheat) {
        $_SESSION["doCheat"] = True;
    }
    return $app->response->redirect("guess/play");
});
