<?php

namespace Jen\Movie;

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
class MovieController implements AppInjectableInterface
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
     * @return object
     */
    public function indexAction() : object
    {
        $title = "Movie database | oophp";

        $page = $this->app->page;
        $db = $this->app->db;
        $db->connect();

        $view[] = "movie/show-all";
        $sql = "SELECT * FROM movie;";
        $res = $db->executeFetchAll($sql);

        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Initialize the game
     * GET mountpoint/init
     *
     * @return object
     */
    public function searchTitleAction() : object
    {
        $title = "Search title | Movie";

        $page = $this->app->page;
        $db = $this->app->db;
        $db->connect();

        $view[] = "movie/search-title";
        $view[] = "movie/show-all";
        $searchTitle = getGet("searchTitle");

        if ($searchTitle) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $db->executeFetchAll($sql, [$searchTitle]);
        }

        $data = [
            "res" => $res ?? null,
            "searchTitle" => $searchTitle ?? null
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Initialize the game
     * GET mountpoint/init
     *
     * @return object
     */
    public function searchYearAction() : object
    {
        $title = "Search year | Movie";

        $page = $this->app->page;
        $db = $this->app->db;
        $db->connect();

        $view[] = "movie/search-year";
        $view[] = "movie/show-all";
        $year1 = getGet("year1");
        $year2 = getGet("year2");

        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $res = $db->executeFetchAll($sql, [$year1, $year2]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $res = $db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $res = $db->executeFetchAll($sql, [$year2]);
        }

        $data = [
            "res" => $res ?? null,
            "year1" => $year1 ?? null,
            "year2" => $year2 ?? null
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Initialize the game
     * GET mountpoint/init
     *
     * @return object
     */
    public function selectActionGet() : object
    {
        $title = "Select a movie | Movie";
        $page = $this->app->page;
        $db = $this->app->db;
        $db->connect();

        $view[] = "movie/movie-select";
        $sql = "SELECT id, title FROM movie;";
        $movies = $db->executeFetchAll($sql);

        $data = [
            "movies" => $movies ?? null
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Initialize the game
     * POST mountpoint/init
     *
     * @return object
     */
    public function selectActionPost() : object
    {
        $response = $this->app->response;
        $db = $this->app->db;
        $db->connect();
        $movieId = getPost("movieId");

        if (getPost("doDelete")) {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $db->execute($sql, [$movieId]);
            return $response->redirect("movie/select");

        } elseif (getPost("doAdd")) {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $db->execute($sql, ["A title", 2017, "../img/movie/noimage.png"]);
            $movieId = $db->lastInsertId();
            return $response->redirect("movie/edit?movieId=$movieId");

        } elseif (getPost("doEdit") && is_numeric($movieId)) {
            return $response->redirect("movie/edit?movieId=$movieId");
        }
    }

    /**
     *
     *
     *
     * @return object
     */
    public function editActionGet() : object
    {
        $title = "Movie update | Movie";
        $page = $this->app->page;
        $db = $this->app->db;
        $db->connect();
        $view[] = "movie/movie-edit";

        $movieId = getGet("movieId");

        $sql = "SELECT * FROM movie WHERE id = ?;";
        $movie = $db->executeFetchAll($sql, [$movieId]);
        $movie = $movie[0];

        $data = [
            "movie" => $movie ?? null
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     *
     *
     *
     * @return object
     */
    public function editActionPost() : object
    {
        $title = "UPDATE movie";
        $page = $this->app->page;
        $db = $this->app->db;
        $db->connect();
        $view[] = "movie/movie-edit";

        $movieId    = getPost("movieId") ?: getGet("movieId");
        $movieTitle = getPost("movieTitle");
        $movieYear  = getPost("movieYear");
        $movieImage = getPost("movieImage");

        if (getPost("doSave")) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
            return $this->app->response->redirect("movie/select");
        }
    }

    /**
     *
     *
     *
     * @return void
     */
    private function addView($view, $data = null) : void
    {
        $page = $this->app->page;
        $page->add("movie/header");

        if (null === $data) {
            $data = [];
        }

        foreach ($view as $value) {
            $page->add($value, $data);
        }
    }
}
