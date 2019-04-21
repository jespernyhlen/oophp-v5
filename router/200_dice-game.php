<?php
/**
 * Create routes using $app programming style.
 */

/**
 * Init the game and redirect to play the game
 */
$app->router->get("dice/init", function () use ($app) {
    // Init the session for gamestart
    $_SESSION["game"] = new Jen\Dice\DiceGame;
    $game = $_SESSION["game"];

    return $app->response->redirect("dice/save-session");
});

/**
 * Play the game
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Spela först till 100";

    $game = $_SESSION["game"];
    if ($game->roundFinished()) {
        $game->startRound();
    }

    $data = [
        "playerCurrentScore" => $_SESSION["playerCurrentScore"] ?? 0,
        "playerScore"        => $_SESSION["playerScore"] ?? 0,
        "AICurrentScore"     => $_SESSION["AICurrentScore"] ?? 0,
        "AIScore"            => $_SESSION["AIScore"] ?? 0,
        "playerGraphic"      => $_SESSION["playerGraphic"] ?? null,
        "AIGraphic"          => $_SESSION["AIGraphic"] ?? null
        // "winMessage" => $_SESSION["diceGraphic"] ?? null
    ];


    $_SESSION["game"] = $game;

    $app->page->add("dice/play", $data);
    $app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Redirect to specific route depending on POST option
 */
$app->router->post("dice/game_redirect", function () use ($app) {

    // $_SESSION["guess"] = $_POST["guess"] ?? null;
    // $res = null;
    $game = $_SESSION["game"];

    $app->page->add("dice/debug");

    if (isset($_POST["initGame"])) {
        return $app->response->redirect("dice/init");
    } elseif (isset($_POST["rollDice"])) {
        return $app->response->redirect("dice/roll");
    } elseif (isset($_POST["saveDice"])) {
        return $app->response->redirect("dice/save");
    }
});


/**
 * Play the game - Make a guess
 */
$app->router->get("dice/roll", function () use ($app) {
    $game = $_SESSION["game"];
    $game->playerRoll();

    return $app->response->redirect("dice/save-session");
});


/**
 * Play the game - Make a guess
 */
$app->router->get("dice/save", function () use ($app) {
    $game = $_SESSION["game"];

    $game->AIRoll();

    return $app->response->redirect("dice/save-session");
});

/**
 * Play the game - Make a guess
 */
$app->router->get("dice/save-session", function () use ($app) {
    $game = $_SESSION["game"];

    $_SESSION["playerCurrentScore"] = $game->player()->score() ?? 0;
    $_SESSION["playerScore"]        = $game->playerScore() ?? 0;
    $_SESSION["AICurrentScore"]     = $game->AI()->score() ?? 0;
    $_SESSION["AIScore"]            = $game->AIScore() ?? 0;
    $_SESSION["playerGraphic"]      = $game->playerGraphic() ?? null;
    $_SESSION["AIGraphic"]          = $game->AIGraphic() ?? null;

    $_SESSION["game"] = $game;

    return $app->response->redirect("dice/play");
});
