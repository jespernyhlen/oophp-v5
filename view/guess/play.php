<?php

namespace Anax\View;

?>
<div class="game-container">    
    <h1>Guess my number</h1>

    <p>Guess a number betweeen 1 and 100, you have <b><?= $tries ?></b> left.</p>

    <?php $noClick = ($tries < 1 || $correct) ? "noclick" : ''; ?>

    <form method="post" action="guess_redirect">
        <input type="number" name="guess" min="1" max="100">
        <div class="">
            <input hidden type="text" name="posted" value="posted">
            <input type="submit" name="doInit" value="Start from beginning">
            <input class="<?= $noClick ?>" type="submit" name="doGuess" value="Make a guess">
            <input class="<?= $noClick ?>" type="submit" name="doCheat" value="Cheat">
        </div>
    </form>


    <?php if ($res && $tries > 0 && $correct != true) : ?>
        <p class="guess">Number is: <b><?= $res ?></b></p>
        <p class="guess">You guessed: <b><?= $guess ?></b></p>
    <?php elseif ($tries == 0 || $correct) : ?>
        <p class="guess"><b><?= $res ?></b></p>
        <p class="guess">You guessed: <b><?= $guess ?></b></p>
        <p class="guess"><b>Press 'Start from beginning' to play again.</b></p>
    <?php endif; ?>

    <?php if ($doCheat) : ?>
        <p>CHEAT: Current number is <b><?= $number ?></b>.</p>
    <?php endif; ?>
</div>

<!-- <pre> -->
<!-- var_dump($_POST) -->
