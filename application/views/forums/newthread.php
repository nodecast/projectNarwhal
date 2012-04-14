<h2 class="center"><a href="/forums/">Forums</a> &gt; <a href="/forums/view_forum/<?= $forum['_id']; ?>"><?= $forum['name']; ?></a> &gt; New Thread</h2>

<?= validation_errors(); ?>
<div class="head center">New Thread</div>
<div class="box center">
	<?= form_open('/forums/new_thread/'.$forum['_id']); ?>
		<table>
			<tr>
				<td><div class="label">Title:&nbsp;&nbsp;</div></td>
				<td><input type="text" size="80" name="title" value="<?= set_value('title') ?>"></td>
			</tr>
			<tr>
				<td><div class="label">Body:&nbsp;&nbsp;</div></td>
				<td><textarea id="body" name="body" rows="10" cols="80"><?= set_value('body') ?></textarea></td>
			</tr>
		</table>
		<div class="pad">
			<input type="submit" name="submit" value="Create Thread">
			<input type="button" id="preview_button" name="preview" value="Preview Thread">
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
			{body: $('#body').val(), fancy: true},
			function(responseText){
				$('#preview_box').html(responseText);
				document.location = '#preview_post';
			},
			"html"
		);
	});
</script>
