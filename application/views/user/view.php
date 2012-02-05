	<h2><?= $user['username'] ?></h2>

	<div class="sidebar">
		<div class="box">
			<div class="head colhead_dark">Avatar</div>
			<div align="center"><img src="<?= $user['avatar'] ?>" width="150" alt="<?= $user['username'] ?>'s avatar"></div>
		</div>
		<div class="box">
			<div class="head colhead_dark">Stats</div>
			<ul class="stats nobullet">
				<li>Joined: <span title="Apr 20 2010, 02:55">1 year, 9 months ago</span></li>
				<li>Last Seen: <span title="Feb 03 2012, 03:34">Just now</span></li>
				<li>Uploaded: <?= $display['upload']; ?></li>
				<li>Downloaded: <?= $display['download']; ?></li>
				<li>Ratio: <?= $display['ratio']; ?></li>
				<li>Required Ratio: --</li>
				<li>Bonus Points: <a href="exchange.php"><?= number_format($user['points']); ?></a></li>
			</ul>
		</div>
		<div class="box">
			<div class="head colhead_dark">Ranks (percentile)</div>
			<ul class="stats nobullet">
				<li>Data uploaded: 98</li>
				<li>Data downloaded: 98</li>
				<li>Torrents uploaded: 98</li>
				<li>Requests filled: 98</li>
				<li>Posts made: 100</li>
				<li><strong>Overall rank: 98</strong></li>
			</ul>
		</div>
		<div class="box">
			<div class="head colhead_dark">Personal</div>
			<ul class="stats nobullet">
				<li>Class: Moderator</li>
				<li>Paranoia Level: 2</li>
			</ul>
		</div>
		<div class="box">
			<div class="head colhead_dark">Community</div>
			<ul class="stats nobullet">
				<li>Forum Posts: 2704 [<a href="userhistory.php?action=posts&amp;userid=7005" title="View">View</a>]</li>
				<li>Torrent Comments: 69</li>
				<li>Requests filled: 30 for 468.87 GB [<a href="requests.php?type=filled&amp;userid=7005" title="View">View</a>]</li>
				<li>Uploaded: 81 [<a href="torrents.php?type=uploaded&amp;userid=7005" title="View">View</a>]</li>
			</ul>
		</div>
	</div>
	<div class="main_column">
		<div class="box">
			<div class="head">Profile&nbsp;-&nbsp;<?= $user['title'] ?></div>
			<div class="pad">
				This profile is currently empty.
			</div>
		</div>
	<table cellpadding="6" cellspacing="1" border="0" class="border" width="100%">
	<tbody><tr class="colhead_dark">
		<td class="small"></td>
		<td style="width:48%;">
			<a href="requests.php?order=name&amp;sort=asc&amp;search=&amp;tag=&amp;tags="><strong>Request Name</strong></a>
		</td>
		<td class="nobr"><strong>
Vote 
		</strong></td>
		<td>
			<a href="requests.php?order=bounty&amp;sort=desc&amp;search=&amp;tag=&amp;tags="><strong>Bounty</strong></a>
		</td>
		<td>
			<a href="requests.php?order=id&amp;sort=desc&amp;search=&amp;tag=&amp;tags="><strong>Requested on</strong></a>
		</td>
		<td>
			<strong>Comments</strong>
		</td>
	</tr>

<tr class="datatable_rowb nobr"><td colspan="8">Nothing found!</td></tr>	</tbody></table>

	</div>
