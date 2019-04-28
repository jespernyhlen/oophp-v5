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
    $game->startRound();

    $data = [
        "playerCurrentScore"    => $_SESSION["playerCurrentScore"] ?? 0,
        "playerScore"           => $_SESSION["playerScore"] ?? 0,
        "computerCurrentScore"  => $_SESSION["computerCurrentScore"] ?? 0,
        "computerScore"         => $_SESSION["computerScore"] ?? 0,
        "playerGraphic"         => $_SESSION["playerGraphic"] ?? null,
        "computerGraphic"       => $_SESSION["computerGraphic"] ?? null,
        "winMessage"            => $_SESSION["winMessage"] ?? null,
        "noclick"               => $_SESSION["noclick"] ?? null,
        "playerHistogram"       => $_SESSION["playerHistogram"] ?? null,
        "computerHistogram"     => $_SESSION["computerHistogram"] ?? null,
        "game"     => $_SESSION["game"] ?? null



    ];

    $_SESSION["game"] = $game;

    $app->page->add("dice/play", $data);
    // $app->page->add("dice/debug");

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

    $game->computerRoll();

    return $app->response->redirect("dice/save-session");
});

/**
 * Play the game - Make a guess
 */
$app->router->get("dice/save-session", function () use ($app) {
    $game = $_SESSION["game"];
    $graphics = $game->graphics();
    $scores = $game->scores();


    $_SESSION["playerCurrentScore"]     = $game->player()->score() ?? 0;
    $_SESSION["playerScore"]            = $scores[0] ?? 0;
    $_SESSION["computerCurrentScore"]   = $game->computer()->score() ?? 0;
    $_SESSION["computerScore"]          = $scores[1] ?? 0;
    $_SESSION["playerGraphic"]          = $graphics[0] ?? null;
    $_SESSION["computerGraphic"]        = $graphics[1] ?? null;
    $_SESSION["noclick"]                = "";

    $_SESSION["playerHistogram"]        = $game->printHistogram()[0] ?? null;
    $_SESSION["computerHistogram"]      = $game->printHistogram()[1] ?? null;




    if ($game->gotWinner($_SESSION["playerScore"], $_SESSION["computerScore"])) {
         $_SESSION["winMessage"] = $game->showWinner($_SESSION["playerScore"], $_SESSION["computerScore"]);
         $_SESSION["noclick"] = "noclick";
    } else {
        $_SESSION["winMessage"] = null;
    }

    $_SESSION["game"] = $game;

    return $app->response->redirect("dice/play");
});
