<div class="sidebar">
	<div class="box">
		<div class="head colhead_dark"><strong>Stats</strong></div>
		<ul class="stats nobullet">
			<li>Maximum Users: <?= $stats['max_users']; ?></li>
			<li>Enabled Users: <?= $stats['enabled_users']; ?></li>
			<li>Online Users: <?= $stats['online_users']; ?></li>
			<li>Users active today: <?= $stats['users_active_day']; ?></li>
			<li>Users active this week: <?= $stats['users_active_week']; ?></li>
			<li>Users active this month: <?= $stats['users_active_month']; ?></li>
			<li>Torrents: <?= $stats['torrents']; ?></li>
			<li>Requests: <?= $stats['requests']; ?> (<?= $stats['requests_percent']; ?>% filled)</li>
			<li>Snatches: <?= $stats['snatches']; ?></li>
			<li>Peers: 88,955</li>
			<li>Seeders: 87,451</li>
			<li>Leechers: 1,504</li>
			<li>Seeder/Leecher Ratio: <span class="r50">58.15</span></li>
		</ul>
	</div>
</div>
<div class="main_column">
	<?php foreach($news as $item): ?>
	<div class="box">
		<div class="head"><strong><?= $item['name'] ?></strong><span class="date">posted <?= $item['ago'] ?></span></div>
		<div class="pad">
			<?= $ci->textformat->parse($item['body']); ?>
		</div>
	</div>
	<?php endforeach; ?>
</div>
