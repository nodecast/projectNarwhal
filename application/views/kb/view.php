<h3><?= htmlspecialchars($article['name']) ?></h3>

<div class="kb_article_body">
  <?php if ($can_edit) { ?>
    <span class="right"><a href="/kb/edit/<?= $article['id'] ?>">Edit</a> | <a href="/kb/delete/<?= $article['id'] ?>">Delete</a></span>
  <?php } ?>
  <?= $article['html_src'] ?>
</div>