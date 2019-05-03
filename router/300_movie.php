<?php
/**
 * Create routes using $app programming style.
 */

/**
 * Init the game and redirect to play the game
 */
 /**
  * Show all movies.
  */
 $app->router->get("movie", function () use ($app) {
     $title = "Movie database | oophp";

     $app->db->connect();
     $sql = "SELECT * FROM movie;";
     $res = $app->db->executeFetchAll($sql);

     $app->page->add("movie/index", [
         "res" => $res,
     ]);

     return $app->page->render([
         "title" => $title,
     ]);
 });
