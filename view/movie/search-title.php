<?php

namespace Anax\View;

?>

<form method="get">
    <fieldset>
    <legend>Search</legend>
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value="<?= esc($searchTitle) ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    <p><a href="<?= url("movie/index") ?>">Show all</a></p>
    </fieldset>
</form>
