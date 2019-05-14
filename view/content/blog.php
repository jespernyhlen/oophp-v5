<?php
namespace Anax\View;

if (!$res) {
    return;
}
?>

<article>

<?php foreach ($res as $row) : ?>
    <?php if ($row->status != "isDeleted") : ?>
    <section>
        <header>
            <h1><a href="<?= url("contentcms/showblog/" . esc($row->slug)) ?>"><?= esc($row->title) ?></a></h1>
            <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
        </header>
        <?= $row->data ?>
    </section>
    <?php endif; ?>

<?php endforeach; ?>

</article>
