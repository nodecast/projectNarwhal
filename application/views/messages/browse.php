<div class="thin">
	<h2><?= $box['this']; ?></h2>
	<div class="linkbox">
		<a href="/messages/send/">[New Message]</a>&nbsp;<a href="/messages/browse/<?= strtolower($box['other']); ?>/">[<?= $box['other']; ?>]</a><br>
		<?php if($results > $perpage) { ?>
			<?= $this->utility->get_page_nav('/messages/browse/'.strtolower($box['this']).'/', $page, $results, $perpage); ?>
		<?php } ?>
	</div>
	<div class="box pad">
		<?= form_open('/messages/delete/', array('id' => 'messageform')); ?>
			<table>
				<tr class="colhead">
					<td style="width:10px"><input type="checkbox" id="checkAllBoxes"></td>
					<td style="width:40%">Subject</td>
					<td>Sender</td>
					<td>Date</td>
				</tr>
				<?php foreach($messages as $message):
					$unread = !in_array($this->utility->current_user('_id'), $message['read']);
				?>
				<tr>
					<td class="center"><input type="checkbox" class="deletebox" name="messages[]" value="<?= $message['_id']; ?>"></td>
					<td>
						<?= $unread ? '<strong>' : '' ?><a href="/messages/view/<?= $message['_id']; ?>"><?= $message['subject']; ?></a><?= $unread ? '</strong>' : '' ?>
					</td>
					<td><?= $this->utility->format_name($message['owner']); ?></td>
					<td><span title="<?= $this->utility->format_datetime($message['time']); ?>"><?= $this->utility->time_diff_string($message['time']); ?></span></td>
				</tr>
				<?php endforeach; ?>
			</table>
			<input type="submit" value="Delete messages">
		</form>
	</div>
	
	<script type="text/javascript">
		$('#checkAllBoxes').click(function() {
    		$(".deletebox").attr('checked', $('#checkAllBoxes').is(':checked'));    
    	});
	</script>
	
	<?php if($results > $perpage) { ?>
	<div class="linkbox">
		<?= $this->utility->get_page_nav('/messages/browse/'.strtolower($box['this']).'/', $page, $results, $perpage); ?>
	</div>
	<?php } ?>
</div>
