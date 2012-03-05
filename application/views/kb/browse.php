<?php if($articles['count'] == 0) { // Articles not found ?>
<div class="box pad center">
  <h2>No articles found.</h2>
</div>
<?php } else {  // Articles found ?>


<div class="box center">
  <span><?= number_format($articles['count']); ?> articles(s) found</span>
</div>

<table class="kb_table" id="kb_table">
  <tr class="colhead">
    <td style="width:100%;"><a href="#">Name</a></td>
  </tr>
  <?php foreach($articles['data'] as $article) { ?>
  <tr class="article">
    <td><a href="/kb/view/<?= $article['id'] ?>" title="Read Article"><?= $article['name'] ?></a></td>
  </tr>
  <?php } ?>
</table>

<?php } // Articles found/not found ?> 