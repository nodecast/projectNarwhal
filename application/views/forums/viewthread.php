<script type="text/javascript">
	ajaxQuoteString = 'getForumPostBBCode';
</script>

<h2><a href="/forums/">Forums</a> &gt; <a href="/forums/view_forum/<?= $forum['_id']; ?>"><?= $forum['name']; ?></a> &gt; <?= $thread['name']; ?></h2>
<div class="linkbox">
	<?= $this->utility->get_page_nav('/forums/view_thread/'.$thread['_id'].'/', $page, $count, $perpage); ?>
</div>
<?php foreach($posts as $post) {
	$post['owner_data'] = $this->usermodel->getData($post['owner']);
	$post['edit'] = $post['owner'] == $this->utility->current_user('_id');
	$this->load->view('partials/post', $post);
} ?>
<div class="box pad center" id="reply">
	<h2>Reply</h2>
	<?= form_open('/forums/reply/'.$thread['_id']); ?>
		<div id="replytext">
			<textarea id="quickpost" name="body" cols="90" rows="8"></textarea><br>
		</div>
		<div id="replybuttons">
			<input type="button" value="Preview" id="preview_button">
			<input type="submit" value="Reply">
		</div>
	</form>
</div>
<div id="preview_post" class="box pad">
<?php
   	$data = array();
   	$data['_id'] = 'preview';
   	$data['owner'] = $this->utility->current_user('_id');
   	$data['time'] = time();
   	$data['owner_data'] = $this->utility->current_user();
   	$data['body'] = '';
   	$data['html'] = '<div id="preview_box"></div>';
   	$this->load->view('partials/post', $data);
?>
</div>
<script type="text/javascript">
	$('#preview_post').hide();
	$('#preview_button').click(function(){
		$('#preview_box').html('<h3>Loading...</h3>');
		$('#preview_post').show();
		$.post(
			'/ajax/preview/',
			{body: $('#quickpost').val(), fancy: true},
			function(responseText){
				$('#preview_box').html(responseText);
				document.location = '#preview_post';
			},
			"html"
		);
	});
</script>

<h2><a href="/forums/">Forums</a> &gt; <a href="/forums/view_forum/<?= $forum['_id']; ?>"><?= $forum['name']; ?></a> &gt; <?= $thread['name']; ?></h2>
<div class="linkbox">
	<?= $this->utility->get_page_nav('/forums/view_thread/'.$thread['_id'].'/', $page, $count, $perpage); ?>
</div>
