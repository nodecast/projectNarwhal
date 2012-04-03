<!DOCTYPE HTML>
<html>
<head>
	<title>{title}</title>
	<link rel="stylesheet" href="<?= $user['stylesheet']; ?>" type="text/css" media="screen">
	<meta http-equiv="Content-Type" CONTENT="text/html; charset=utf-8">
	<script type="text/javascript" src="<?= $static_server; ?>/scripts/jquery.min.js"></script>
	<script type="text/javascript" src="<?= $static_server; ?>/scripts/global.js"></script>
	<script type="text/javascript" src="<?= $static_server; ?>/scripts/raphael-min.js"></script>
	<script type="text/javascript" src="<?= $static_server; ?>/scripts/g.raphael-min.js"></script>
	<script type="text/javascript" src="<?= $static_server; ?>/scripts/g.line-min.js"></script>
</head>
<body>
	<div id="header">
		<a href="/"><div id="logo"></div></a>
		<div id="userinfo">
		<ul id="userinfo_username">
			<li><a href="/user/view/<?= $user['_id'] ?>" class="username"><?= $user['username']; ?></a></li>
			<li class="brackets"><a href="/user/edit/<?= $user['_id'] ?>">Edit</a></li>
			<li class="brackets"><a href="/logout">Logout</a></li>
		</ul>
		<ul id="userinfo_major">
			<li class="brackets"><strong><a href="/torrents/upload">Upload</a></strong></li>
			<li class="brackets"><strong><a href="/user/invite">Invite (<?= $user['invites'] ?>)</a></strong></li>
		</ul>
		<ul id="userinfo_stats">
			<li>Up: <span class="stat"><?= $display['upload'] ?></span></li>
			<li>Down: <span class="stat"><?= $display['download'] ?></span></li>
			<li class="ratiopipe"> | </li>
			<li>Ratio: <span class="stat"><?= $display['ratio'] ?></span></li>
			<li>(<a href="kb.php?id=5">required</a>: <span class="stat">--</span>)</li>
			<li class="ratiopipe"> | </li>
			<li>Points: <span class="stat"><a href="/exchange"><?= number_format($user['points']) ?></a></span></li>
		</ul>
		<ul id="userinfo_minor">
			<li><a href="/messages/">Messages</a></li>
			<li><a href="#">Uploads</a></li>
			<li><a href="/bookmarks">Bookmarks</a></li>
			<li><a href="/user/notify">Notifications</a></li>
			<li><a href="#">Posts</a></li>
			<li><a href="/friends">Friends</a></li>
		</ul>
	</div>
	<div id="menu">
		<ul>
			<li id="nav_index"><a href="/">Home</a></li>
			<li id="nav_torrents"><a href="/torrents/browse">Torrents</a></li>
			<li id="nav_requests"><a href="/requests/browse">Requests</a></li>
			<li id="nav_forums"><a href="/forums">Forums</a></li>
			<li id="nav_top10"><a href="/top10">Top&nbsp;10</a></li>
			<li id="nav_kb"><a href="/kb">Knowledge&nbsp;Base</a></li>
			<li id="nav_staff"><a href="/staff">Staff</a></li>
			<li id="nav_chat"><a target="_blank" href="<?= $this->config->item('chat_url') ?>/?nick=<?= $user['username'] ?>&channels=#lounge">Chat</a></li>
		</ul>
	</div>
	<div id="alerts">
		<?php foreach($alerts as $alert): ?>
		<div class="alertbar blend">
			<?= $alert['body'] ?>
			<span class="close"><a href="/alerts/delete/<?= $alert['_id']; ?>">[x]</a></span>
		</div>
		<?php endforeach; ?>
	</div>
	<div id="searchbars">
		<ul>
			<li><form action="/search/torrents"><input type="text" name="q" placeholder="Torrents"><input value="Search" type="submit" class="hidden"></form></li>
			<li><form action="#"><input type="text" name="search" placeholder="Requests"><input value="Search" type="submit" class="hidden"></form></li>
			<li><form action="#"><input type="text" name="search" placeholder="Forums"><input value="Search" type="submit" class="hidden"></form></li>
			<li><form action="/search/users"><input type="text" name="q" placeholder="Users"><input value="Search" type="submit" class="hidden"></form></li>
		</ul>
	</div>
</div>
<div id="content">
