<?php

namespace Jen\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceGameController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "indexview";
    }



    /**
     * Initialize the game
     * GET mountpoint/init
     *
     * @return object
     */
    public function initAction() : object
    {
        $response = $this->app->response;
        $session = $this->app->session;

        $game = new DiceGame;
        $session->set("game", $game);
        $this->saveToSession();

        return $response->redirect("dicegame/play");
    }



    /**
     * Handle get action from /play
     * GET mountpoint/play
     *
     * @return object
     */
    public function playActionGet() : object
    {
        $session = $this->app->session;
        $page = $this->app->page;

        $title = "Spela först till 100";
        $game = $session->get("game");
        $game->startRound();

        $playerCurrentScore   = $session->get("playerCurrentScore", 0);
        $playerScore          = $session->get("playerScore", 0);
        $computerCurrentScore = $session->get("computerCurrentScore", 0);
        $computerScore        = $session->get("computerScore", 0);
        $playerGraphic        = $session->get("playerGraphic");
        $computerGraphic      = $session->get("computerGraphic");
        $winMessage           = $session->get("winMessage");
        $noclick              = $session->get("noclick");
        $playerHistogram      = $session->get("playerHistogram");
        $computerHistogram    = $session->get("computerHistogram");

        $data = [
            "playerCurrentScore"    => $playerCurrentScore,
            "playerScore"           => $playerScore,
            "computerCurrentScore"  => $computerCurrentScore,
            "computerScore"         => $computerScore,
            "playerGraphic"         => $playerGraphic,
            "computerGraphic"       => $computerGraphic,
            "winMessage"            => $winMessage,
            "noclick"               => $noclick,
            "playerHistogram"       => $playerHistogram,
            "computerHistogram"     => $computerHistogram
        ];

        $session->set("game", $game);

        $page->add("dice/play", $data);

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Handle post action from /play
     * POST mountpoint/play
     *
     * @return
     */
    public function playActionPost()
    {
        $session = $this->app->session;
        $response = $this->app->response;
        $request = $this->app->request;

        $game = $session->get("game");

        if (null !== $request->getPost("initGame")) {
            return $response->redirect("dicegame/init");
        } elseif (null !== $request->getPost("rollDice")) {
            return $this->roll();
        } elseif (null !== $request->getPost("saveDice")) {
            return $this->saveDice();
        }
    }



    /**
     * Roll the dice for player
     * Save values to session
     *
     * @return object
     */
    private function roll() : object
    {
        $game = $this->app->session->get("game");
        $game->playerRoll();
        $this->saveToSession();

        return $this->app->response->redirect("dicegame/play");
    }


    /**
     * Save players dicevalues and makes computer roll
     * Save values to session
     *
     * @return object
     */
    private function saveDice() : object
    {
        $game = $this->app->session->get("game");
        $game->computerRoll();
        $this->saveToSession();

        return $this->app->response->redirect("dicegame/play");
    }



    /**
     * Save values to session to work with.
     *
     *
     * @return void
     */
    private function saveToSession() : void
    {
        $session = $this->app->session;
        $game = $session->get("game");
        $graphics = $game->graphics();
        $scores = $game->scores();

        $session->set("playerCurrentScore", $game->player()->score());
        $session->set("playerScore", $scores[0]);
        $session->set("computerCurrentScore", $game->computer()->score());
        $session->set("computerScore", $scores[1]);
        $session->set("playerGraphic", $graphics[0]);
        $session->set("computerGraphic", $graphics[1]);
        $session->set("noclick", "");
        $session->set("playerHistogram", $game->printHistogram()[0]);
        $session->set("computerHistogram", $game->printHistogram()[1]);

        if ($game->gotWinner($scores[0], $scores[1])) {
             $message = $game->showWinner($scores[0], $scores[1]);
             $session->set("winMessage", $message);
             $session->set("noclick", "noclick");
        } else {
            $session->set("winMessage", null);
        }
        $session->set("game", $game);
    }
}
