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
        <h2 class="total-score"> <?= $computerScore ?></h2>
        <div class="round-score">
            <h2>Round pts</h2>
            <h2><?= $computerCurrentScore ?></h2>
        </div>
        <div class="dicegraphic-container">
            <?php if ($computerGraphic) : ?>
                <p class="dice-utf8">
                <?php foreach ($computerGraphic as $value) : ?>
                    <i class="<?= $value ?>"></i>
                <?php endforeach; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="histogram-container">
        <div class="dice-player">
            <?php if (strlen($playerHistogram) > 0) : ?>
                <h4>Rolled dices</h4>
                <p><?= $playerHistogram  ?></p>
            <?php endif; ?>

        </div>
        <div class="dice-player">
            <?php if (strlen($computerHistogram) > 0) : ?>
                <h4>Rolled dices</h4>
                <p><?= $computerHistogram  ?></p>
            <?php endif; ?>
        </div>
    </div>






    <div class="form-container">
        <form method="post" action="play">
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
