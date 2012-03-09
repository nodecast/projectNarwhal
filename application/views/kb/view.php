<div class="box">
	<div class="head"><?= htmlspecialchars($article['name']) ?>
		<?php if ($can_edit) { ?>
    		<span class="right"><a href="/kb/edit/<?= $article['_id'] ?>">Edit</a> | <a href="/kb/delete/<?= $article['_id'] ?>">Delete</a></span>
  		<?php } ?>
  	</div>
	<div class="pad">
		<?= $article['html_src'] ?>
	</div>
</div>
