<div class="thin">
	<h2>Forums</h2>
	<table>
		<tr class="colhead">
			<td>Read</td>
			<td style="width:40%;">Forum</td>
			<td>Threads</td>
			<td>Posts</td>
			<td>Last Post</td>
		</tr>
		<?php foreach($forums as $forum):
			$threads = $this->forumsmodel->countThreadsInForum($forum['_id']);
			$posts = $this->forumsmodel->countPostsInForum($forum['_id']);
		?>
		<tr>
			<td><div class="<?= (in_array($userid, $forum['read']) ? 'read' : 'unread'); ?>_icon"></div></td>
			<td>
				<h4 class="min_padding">
					<a href="/forums/view/<?= $forum['_id']; ?>"><?= $forum['name']; ?></a>
				</h4>
				<p class="min_padding"><?= $forum['description']; ?></p>
			</td>
			<td><?= $threads ?></td>
			<td><?= $posts ?></td>
			<td>
				<?php if($threads && $posts && ($post = $this->forumsmodel->getMostRecentPost($forum['_id'])) && ($thread = $this->forumsmodel->getThread($post['thread']))) { ?>
					<p class="min_padding">By <?= $this->utility->format_name($post['owner']); ?> <span title="<?= $this->utility->format_datetime($post['time']); ?>"><?= $this->utility->time_diff_string($post['time']); ?></span></p>
					<p class="min_padding">
					In <strong><a href="/forums/view/<?= $post['forum']; ?>/<?= $post['thread'] ?>" title="<?= $thread['name'] ?>"><?= $thread['name'] ?></a></strong>
					</p>
				<?php } ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<div class="linkbox"><a href="/forums/catchup">Mark all as read</a></div>
</div>
