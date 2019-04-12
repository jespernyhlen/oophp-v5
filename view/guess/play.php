<?php

namespace Anax\View;

?>
<h1>Guess my number</h1>

<p>Guess a number betweeen 1 and 100, you have <b><?= $tries ?></b> left.</p>

<?php $noClick = ($tries < 1 || $res == "CORRECT") ? "noclick" : ''; ?>

<form method="post" action="guess_redirect">
    <input type="number" name="guess" min="1" max="100">
    <div class="">
        <input hidden type="text" name="posted" value="posted">
        <input type="submit" name="doInit" value="Start from beginning">
        <input class="<?= $noClick ?>" type="submit" name="doGuess" value="Make a guess">
        <input class="<?= $noClick ?>" type="submit" name="doCheat" value="Cheat">
    </div>
</form>


<?php if ($res) : ?>
    <p class="guess">Number is: <b><?= $res ?></b></p>
    <p class="guess">You guessed: <b><?= $guess ?></b></p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>CHEAT: Current number is <b><?= $number ?></b>.</p>
<?php endif; ?>

<!-- <pre> -->
<!-- var_dump($_POST) -->
