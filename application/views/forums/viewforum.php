<div class="thin">
	<h2><a href="/forums/">Forums</a> &gt; <?= $forum['name']; ?></h2>
	<div class="linkbox">
		<a href="/forums/new_thread/<?= $forum['_id']; ?>">New Thread</a>
	</div>
	<div class="linkbox">
		<?= $this->utility->get_page_nav('/forums/view_forum/'.$forum['_id'].'/', $page, $results, $perpage); ?>
	</div>
	<table width="100%">
		<tr class="colhead">
			<td>Read</td>
			<td style="width:380px;">Topic</td>
			<td>Replies</td>
			<td>Author</td>
			<td>Last Post</td>
		</tr>
		<?php foreach($threads as $thread):
			$post = $this->forumsmodel->getLastPost($thread['_id']);
		?>
		<tr>
			<td><div class="<?= ((in_array($userid, $thread['read']) || $catchuptime > $thread['lastupdate']) ? 'read' : 'unread'); ?>_icon"></div></td>
			<td>
				<p class="min_padding">
					<?= ($thread['stickied'] ? 'Sticky: ' : '') ?><strong>
						<a href="/forums/view_thread/<?= $thread['_id']; ?>" title="<?= $thread['name']; ?>"><?= $thread['name']; ?></a>
					</strong>
				 	<?= $this->utility->get_mini_nav($thread['_id'], $post['count']); ?>
				</p>
			</td>
			<td><?= ($post['count'] - 1); ?></td>
			<td><?= $this->utility->format_name($thread['owner']); ?></td>
			<td>
				<?php if($post['count']) { ?>
				<p class="min_padding">By <?= $this->utility->format_name($post['data']['owner']); ?> <br><span title="<?= $this->utility->format_datetime($post['data']['time']); ?>"><?= $this->utility->time_diff_string($post['data']['time']); ?></span></p>
				<?php } ?>
			</td>
		</tr>
		<?php endforeach; ?>
</table>
	<div class="linkbox">
		<?= $this->utility->get_page_nav('/forums/view_forum/'.$forum['_id'].'/', $page, $results, $perpage); ?>
	</div>
</div>
