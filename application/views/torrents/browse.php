<table class="torrent_table" id="torrent_table">
	<tr class="colhead">
		<td class="small"></td>
		<td width="100%"><a href="#">Name</a></td>
		<td>Files</td>
		<td class="stat"><a href="#">Added</a></td>
		<td class="stat"><a href="#">Size</a></td>
		<td class="sign"><img src="/static/common/icons/comments.png" alt="Comments" title="Comments"></td>
		<td class="sign"><a href="#"><img src="/static/common/icons/snatched.png" alt="Snatches" title="Snatches"></a></td>
		<td class="sign"><a href="#"><img src="/static/common/icons/seeders.png" alt="Seeders" title="Seeders"></a></td>
		<td class="sign"><a href="#"><img src="/static/common/icons/leechers.png" alt="Leechers" title="Leechers"></a></td>
	</tr>
	<div class="box center">
		<?= number_format($results); ?> results found.
	</div>
	<?php if($results > 50) { ?>
	<div class="linkbox">
	<?= $ci->utility->get_page_nav('/torrents/browse/', $page, $results, 50); ?>
	</div>
	<?php } foreach($torrents as $torrent): ?>
	<tr class="torrent  ">
		<td class="center"><a href="#"><img src="/static/common/category/<?= $caticons[$torrent['category']]; ?>" alt="<?= $categories[$torrent['category']]; ?>" title="<?= $categories[$torrent['category']]; ?>" width="24" height="24"></a></td>
		<td>
			<span>[<a href="#" title="Download">DL</a> | <a href="#" title="Report">RP</a>] </span>
			<a href="/torrents/view/<?= $torrent['id']; ?>" title="View Torrent"><?= $torrent['name']; ?></a>
			<?php if($torrent['freetorrent']) echo "[<strong>Freeleech!</strong>]"; ?>
			<br>
			<div class="tags">
				<?php foreach($torrent['tags'] as $tag): ?>
				<a href="/torrents/tag/x"><?= $tag ?></a>&nbsp;
				<?php endforeach; ?>
			</div>
		</td>
		<td><?= number_format($torrent['files']); ?></td>
		<td><?= $ci->utility->time_diff_string($torrent['time']); ?></td>
		<td><?= $ci->utility->format_bytes($torrent['size']); ?></td>
		<td><?= number_format(count($torrent['comments'])); ?></td>
		<td><?= number_format($torrent['snatched']); ?></td>
		<td><?= number_format($torrent['seeders']); ?></td>
		<td><?= number_format($torrent['leechers']); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php
	if(count($torrents) == 0) {?>
	<div class="box pad center">
		<h2>No search results.</h2>
	</div>
<?php	}	?>
