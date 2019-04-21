<?php

namespace Anax\View;

?>
<form method="post" action="game_redirect">
    <div class="">
        <input hidden type="text" name="posted" value="posted">
        <input class="" type="submit" name="initGame" value="Init">
        <input class="" type="submit" name="rollDice" value="Roll">
        <input class="" type="submit" name="saveDice" value="Save">
    </div>
</form>

<h1>Player</h1>
<h2>Round pts: <?= $playerCurrentScore ?></h2>
<h2>Total pts: <?= $playerScore ?></h2>


<?php if ($playerGraphic) : ?>
    <p class="dice-utf8">
    <?php foreach ($playerGraphic as $value) : ?>
        <i class="<?= $value ?>"></i>
    <?php endforeach; ?>
    </p>
<?php endif; ?>

<h1>Computer</h1>
<h2>Round pts: <?= $AICurrentScore ?></h2>
<h2>Total pts: <?= $AIScore ?></h2>


<?php if ($AIGraphic) : ?>
    <p class="dice-utf8">
    <?php foreach ($AIGraphic as $value) : ?>
        <i class="<?= $value ?>"></i>
    <?php endforeach; ?>
    </p>
<?php endif; ?>

<!-- <pre> -->
<!-- var_dump($_POST) -->
