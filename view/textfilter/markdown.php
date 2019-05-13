<?php

namespace Anax\View;

if (!$text) {
    return;
}

?>

<h1>Showing off Markdown</h1>

<h2>Markdown source in sample.md</h2>
<pre><?= $text ?></pre>

<h2>Filter Markdown applied, HTML</h2>
<pre><?= $html ?></pre>

<h2>Filter Markdown applied, Output</h2>
<?= $output ?>
