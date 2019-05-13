<?php

namespace Anax\View;

if (!$html) {
    return;
}

?>

<h1>Showing off BBCode</h1>

<h2>Source in bbcode.txt</h2>
<pre><?= $text ?></pre>

<h2>Filter BBCode applied, HTML</h2>
<?= $html ?>

<h2>Filter BBCode applied, Output</h2>
<?= $output ?>

<h2>Filter BBCode/nl2br applied</h2>
<?= $htmlnl2br ?>
