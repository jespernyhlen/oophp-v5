<?php

namespace Anax\View;

?>

<form method="get">
    <fieldset>
    <legend>Search</legend>
    <p>
        <label>Created between:
        <input type="number" name="year1" value="<?= esc($year1) ?: 1900 ?>" min="1900" max="2100"/>
        -
        <input type="number" name="year2" value="<?= esc($year2) ?: 2100 ?>" min="1900" max="2100"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    <p><a href="<?= url("movie/index") ?>">Show all</a></p>
    </fieldset>
</form>
