<article>
    <header>
        <h1><?= esc($res->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= esc($res->modified_iso8601) ?>" pubdate><?= esc($res->modified) ?></time></i></p>
    </header>
    <?= $res->data ?>
</article>
