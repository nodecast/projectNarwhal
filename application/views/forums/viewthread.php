<h2><a href="/forums/">Forums</a> &gt; <a href="/forums/view_forum/<?= $forum['_id']; ?>"><?= $forum['name']; ?></a> &gt; <?= $thread['name']; ?></h2>
<div class="linkbox">
	<?= $this->utility->get_page_nav('/forums/view_thread/'.$thread['_id'].'/', $page, $count, $perpage); ?>
</div>
<?php foreach($posts as $post) {
	$post['owner_data'] = $this->usermodel->getData($post['owner']);
	$this->load->view('partials/post', $post);
} ?>
<h3>Reply</h3>
<div class="box pad">
	<form id="quickpostform" action="" method="post" class="center">
		<div id="quickreplytext">
			<textarea id="quickpost" name="body" cols="90" rows="8"></textarea><br>
		</div>
		<div id="quickreplybuttons">
			<input type="button" value="Preview">
			<input type="submit" value="Reply">
		</div>
	</form>
</div>

<h2><a href="/forums/">Forums</a> &gt; <a href="/forums/view_forum/<?= $forum['_id']; ?>"><?= $forum['name']; ?></a> &gt; <?= $thread['name']; ?></h2>
<div class="linkbox">
	<?= $this->utility->get_page_nav('/forums/view_thread/'.$thread['_id'].'/', $page, $count, $perpage); ?>
</div>
