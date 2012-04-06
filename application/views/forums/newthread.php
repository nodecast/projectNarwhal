<h2 class="center"><a href="/forums/">Forums</a> &gt; <a href="/forums/view_forum/<?= $forum['_id']; ?>"><?= $forum['name']; ?></a> &gt; New Thread</h2>

<?= validation_errors(); ?>
<?php if ($preview) { ?>
	<div class="box center">
			<h4><a href="#postpreview">(Preview below)</a></h4>
	</div>
<?php } ?>

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
				<td><textarea name="body" rows="10" cols="80"><?= set_value('body') ?></textarea></td>
			</tr>
		</table>
		<div class="pad">
			<input type="submit" name="submit" value="Create Thread">
			<input type="submit" name="preview" value="Preview Thread">
		</div>
	</form>
</div>

<?php if ($preview) { ?>
    <?php
    	$data = array();
    	$data['_id'] = 'preview';
    	$data['owner'] = $this->utility->current_user('_id');
    	$data['time'] = time();
    	$data['owner_data'] = $this->utility->current_user();
    	$data['body'] = $body;
    	$this->load->view('partials/post', $data);
    ?>
  	<script type="text/javascript">document.location = '#postpreview';</script>
<?php } ?>
