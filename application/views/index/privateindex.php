<div class="sidebar">
	<div class="box">
		<div class="head colhead_dark"><strong>Stats</strong></div>
		<ul class="stats nobullet">
			<li>Maximum Users: 6,000</li>
			<li>Enabled Users: 6,272</li>
			<li>Online Users: 27</li>
			<li>Users active today: 1,492</li>
			<li>Users active this week: 3,101</li>
			<li>Users active this month: 4,558</li>
			<li>Torrents: 26,571</li>
			<li>Albums: 6,281</li>
			<li>Artists: 5,531</li>
			<li>Requests: 6,792 (80.42% filled)</li>
			<li>Snatches: 679,135</li>

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
		<div class="head"><strong><?= $item['name'] ?></strong><span class="date">posted <?= $item['ago'] ?> ago</span></div>
		<div class="pad">
			<?= $item['body'] ?>
		</div>
	</div>
	<?php endforeach; ?>
</div>
