<h3><?= htmlspecialchars($article['name']) ?></h3>

<div class="kb_article_body">
  <span class="right"><a href="/kb/edit/<?= $article['id'] ?>">Edit</span>
  <?= $article['html_src'] ?>
</div>