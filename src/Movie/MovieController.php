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

        $view[] = "movie/show-all";
        $res = $this->movieFetchAll("SELECT * FROM movie;");
        $data = [
            "res" => $res
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }



    /**
     * Search movies based on title
     * GET movie/search-title
     *
     * @return object
     */
    public function searchTitleAction() : object
    {
        $title = "Search title | Movie";
        $page = $this->app->page;

        $view[] = "movie/search-title";
        $view[] = "movie/show-all";
        $searchTitle = getGet("searchTitle");

        if ($searchTitle) {
            $res = $this->movieFetchAll(
                "SELECT * FROM movie WHERE title LIKE ?;",
                [$searchTitle]
            );
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
     * Search movies based on startyear - endyear
     * GET movie/search-year
     *
     * @return object
     */
    public function searchYearAction() : object
    {
        $title = "Search year | Movie";
        $page = $this->app->page;
        $view[] = "movie/search-year";

        $view[] = "movie/show-all";
        $year1 = getGet("year1");
        $year2 = getGet("year2");

        $res = $this->searchYear($year1, $year2);

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
     * Show movies from database and options for CRUD
     * GET movie/select
     *
     * @return object
     */
    public function selectActionGet() : object
    {
        $title = "Select a movie | Movie";
        $page = $this->app->page;
        $view[] = "movie/movie-select";

        $movies = $this->movieFetchAll("SELECT id, title FROM movie;");

        $data = [
            "movies" => $movies ?? null
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Redirect for CRUD add/edit/delete
     * POST movie/select
     *
     * @return object
     */
    public function selectActionPost() : object
    {
        $db = $this->app->db;
        $db->connect();
        $response = $this->app->response;

        $movieId = getPost("movieId");

        if (getPost("doDelete")) {
            $this->movieDelete($movieId);
            return $response->redirect("movie/select");
        } elseif (getPost("doAdd")) {
            $this->movieAdd();
            $movieId = $db->lastInsertId();
            return $response->redirect("movie/edit?movieId=$movieId");
        } elseif (getPost("doEdit") && is_numeric($movieId)) {
            return $response->redirect("movie/edit?movieId=$movieId");
        }
    }

    /**
     * Show movies from database and current values
     * GET movie/edit
     *
     *
     * @return object
     */
    public function editActionGet() : object
    {
        $title = "Movie update | Movie";
        $page = $this->app->page;
        $view[] = "movie/movie-edit";

        $movieId = getGet("movieId");

        $movie = $this->movieFetchAll(
            "SELECT * FROM movie WHERE id = ?;",
            [$movieId]
        )[0];

        $data = [
            "movie" => $movie ?? null
        ];

        $this->addView($view, $data);

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * Get values posted and update the database values
     * POST movie/edit
     *
     * @return object
     */
    public function editActionPost() : object
    {
        $movieId    = getPost("movieId") ?: getGet("movieId");
        $movieTitle = getPost("movieTitle");
        $movieYear  = getPost("movieYear");
        $movieImage = getPost("movieImage");

        if (getPost("doSave")) {
            $this->movieUpdate(
                $movieId,
                $movieTitle,
                $movieYear,
                $movieImage
            );
            return $this->app->response->redirect("movie/select");
        }
    }

    /**
     * Add views to render on site
     * Optional data to display
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

    /**
     * Return array of movies with year value
     * in the span startyear - endyear
     *
     * @return array
     */
    private function searchYear($startYear = null, $endYear = null) : array
    {
        $res = [];
        if ($startYear && $endYear) {
            $res = $this->movieFetchAll(
                "SELECT * FROM movie WHERE year >= ? AND year <= ?;",
                [$startYear, $endYear]
            );
        } elseif ($startYear) {
            $res = $this->movieFetchAll(
                "SELECT * FROM movie WHERE year >= ?;",
                [$startYear]
            );
        } elseif ($endYear) {
            $res = $this->movieFetchAll(
                "SELECT * FROM movie WHERE year <= ?;",
                [$endYear]
            );
        }
        return $res;
    }

    /**
     * Return all matching movies
     * based on searchquery and/or parameters.
     *
     * @return
     */
    private function movieFetchAll($selectQuery, $searchQuery = null)
    {
        $db = $this->app->db;
        $db->connect();

        if ($searchQuery) {
            $sql = $selectQuery;
            $res = $db->executeFetchAll($sql, $searchQuery);
        } else {
            $sql = $selectQuery;
            $res = $db->executeFetchAll($sql);
        }
        return $res;
    }

    /**
     * Delete a movie from database
     * based on movie ID
     *
     * @return void
     */
    private function movieDelete($movieId) : void
    {
        $db = $this->app->db;
        $db->connect();

        $sql = "DELETE FROM movie WHERE id = ?;";
        $db->execute($sql, [$movieId]);
    }

    /**
     * Add a movie to database
     * with standard values
     *
     * @return void
     */
    private function movieAdd() : void
    {
        $db = $this->app->db;
        $db->connect();

        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $db->execute($sql, ["A title", 2017, "./image/movie/noimage.png?w=270&h=180&cf"]);
    }

    /**
     * Update movie with based on ID
     * Parameters Title, Year, ImgUrl.
     *
     * @return void
     */
    private function movieUpdate($movieId, $movieTitle, $movieYear, $movieImage) : void
    {
        $db = $this->app->db;
        $db->connect();

        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
    }
}
