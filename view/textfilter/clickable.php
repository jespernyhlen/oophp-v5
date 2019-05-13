<?php

namespace Anax\View;

if (!$html) {
    return;
}

?>

<h1>Showing off Clickable</h1>

<h2>Source in clickable.txt</h2>
<pre><?= $text ?></pre>

<h2>Filter Clickable applied, HTML</h2>
<pre><?= $html ?></pre>

<h2>Filter Clickable applied, Output</h2>
<?= $output ?>
