<article>
    <header>
        <h1><?= esc($res->title) ?></h1>
        <p><i>Published: <time datetime="<?= esc($res->published_iso8601) ?>" pubdate><?= esc($res->published) ?></time></i></p>
    </header>
    <?= $res->data ?>
</article>
