<div class="box">
	<div class="head"><?= htmlspecialchars($article['name']) ?>
		<?php if ($can_edit) { ?>
    		<span class="right"><a href="/kb/edit/<?= $article['id'] ?>">Edit</a> | <a href="/kb/delete/<?= $article['id'] ?>">Delete</a></span>
  		<?php } ?>
  	</div>
	<div class="pad">
		<?= $article['html_src'] ?>
	</div>
</div>
