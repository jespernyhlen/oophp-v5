<?php
/**
 * Create routes using $app programming style.
 */

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

    $data = [
        "guess" => $_SESSION["guess"] ?? null,
        "number" => $_SESSION["number"] ?? null,
        "doCheat" => $_SESSION["doCheat"] ?? null,
        "correct" => $_SESSION["correct"] ?? null,
        "tries" => $_SESSION["tries"] ?? null,
        "res" => $_SESSION["res"] ?? null,
    ];
    $_SESSION["guess"] =  null;
    $_SESSION["correct"] = null;
    $_SESSION["doCheat"] =  null;
    $_SESSION["res"] =  null;

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Redirect to specific route depending on POST option
 */
$app->router->post("guess/guess_redirect", function () use ($app) {

    $_SESSION["guess"] = $_POST["guess"] ?? null;
    $res = null;

    if ($_POST["doInit"]) {
        return $app->response->redirect("guess/init");
    } elseif ($_POST["doGuess"]) {
        return $app->response->redirect("guess/do_guess");
    } elseif ($_POST["doCheat"]) {
        $_SESSION["doCheat"] = true;
        return $app->response->redirect("guess/play");
    }
});

/**
 * Play the game - Make a guess
 */
$app->router->get("guess/do_guess", function () use ($app) {
    $guess   = $_SESSION["guess"] ?? null;
    $number  = $_SESSION["number"] ?? null;
    $tries   = $_SESSION["tries"] ?? null;
    // Play game, make a guess
    $guessGame = new Jen\Guess\Guess($number, $tries);
    try {
        $res = $guessGame->makeGuess($guess);
    } catch (TypeError $e) {
    }
    $_SESSION["res"]     = $res;
    $_SESSION["guess"]   = $guess;
    $_SESSION["tries"]   = $guessGame->tries();
    $_SESSION["correct"] = $guessGame->correct();

    return $app->response->redirect("guess/play");
});
