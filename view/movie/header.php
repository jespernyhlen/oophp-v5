<?php

namespace Anax\View;

?>

<navbar class="navbar movie-nav">
    <!-- <a href="?route=select">SELECT *</a> |
    <br> -->
    <a href="<?= url("movie/index") ?>">Show all movies</a>
    <a href="<?= url("movie/search-title") ?>">Search title</a>
    <a href="<?= url("movie/search-year") ?>">Search year</a>
    <a href="<?= url("movie/select") ?>">Select</a>
<!--    <a href="?route=movie-edit">Edit</a> | -->
    <!-- <a href="?route=show-all-sort">Show all sortable</a> |
    <a href="?route=show-all-paginate">Show all paginate</a> | -->
</navbar>
