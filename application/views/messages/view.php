<h2><?= $message['subject'] ?></h2>
<div class="linkbox">
	<a href="/messages/">[Back to inbox]</a>
</div>

<div class="sidebar">
	<div class="box pad">
		<ul>
			<?php
				foreach($message['participants'] as $p) {
					$owner = $message['owner'] == $p;
					echo ($owner ? '<strong>' : '').'<li>'.$this->utility->format_name($p).'</li>'.($owner ? '</strong>' : '');
				}
			?>
		</ul>
		
		<?= form_open('/messages/invite/'.$message['_id']) ?>
			Add a new member:
			<input type="text" name="invite">
		</form>
	</div>
</div>

<div class="main_column">
	<div class="thin">
		<?php foreach($message['messages'] as $m): ?>
		<div class="box vertical_space">
			<div class="head">
				By <?= $this->utility->format_name($m['owner']); ?> <span title="<?= $this->utility->format_datetime($m['time']); ?>"><?= $this->utility->time_diff_string($m['time']); ?></span>
			</div>
			<div class="body">
				<?= $this->textformat->parse($m['body'], $this->config->item('message_cache')) ?>
			</div>
			<br>
		</div>
		<?php endforeach; ?>
		
		<h2>Reply</h2>
		<?= form_open('/messages/reply/'.$message['_id']) ?>
			<div class="box pad center">
			<textarea name="body" cols="90" rows="10"></textarea><br>
			<input type="submit" value="Reply">
			</div>
		</form>
	</div>
</div>
