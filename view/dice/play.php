<?php

namespace Anax\View;

?>
<div class="dice-container">
    <h1><?= $winMessage ?></h1>
    <div class="dice-player">
        <h1>PLAYER</h1>
        <h2 class="total-score"> <?= $playerScore ?></h2>
        <div class="round-score">
            <h2>Round pts</h2>
            <h2><?= $playerCurrentScore ?></h2>
        </div>

        <?php if ($playerGraphic) : ?>
            <p class="dice-utf8">
            <?php foreach ($playerGraphic as $value) : ?>
                <i class="<?= $value ?>"></i>
            <?php endforeach; ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="dice-player">
        <h1>COMPUTER</h1>
        <h2 class="total-score"> <?= $AIScore ?></h2>
        <div class="round-score">
            <h2>Round pts</h2>
            <h2><?= $AICurrentScore ?></h2>
        </div>

        <?php if ($AIGraphic) : ?>
            <p class="dice-utf8">
            <?php foreach ($AIGraphic as $value) : ?>
                <i class="<?= $value ?>"></i>
            <?php endforeach; ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="form-container">
        <form method="post" action="game_redirect">
            <div class="">
                <input hidden type="text" name="posted" value="posted">
                <input class="" type="submit" name="initGame" value="Init">
                <input class="<?= $noclick ?>" type="submit" name="rollDice" value="Roll">
                <input class="<?= $noclick ?>" type="submit" name="saveDice" value="Save">
            </div>
        </form>
    </div>

</div>

<!-- <pre> -->
<!-- var_dump($_POST) -->