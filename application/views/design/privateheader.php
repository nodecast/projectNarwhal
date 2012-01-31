<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Narwhal</title>
        <link rel="stylesheet" href="static/styles/default/style.css" type="text/css" media="screen">
	<meta http-equiv="Content-Type" CONTENT="text/html; charset=utf-8">
</head>
<body>
<div id="header">
	<div id="logo"></div>
		<div id="userinfo">
		<ul id="userinfo_username">
			<li><a href="/user/view/<?= $user['id'] ?>" class="username"><?= $user['username']; ?></a></li>
			<li class="brackets"><a href="/user/edit/<?= $user['id'] ?>">Edit</a></li>
			<li class="brackets"><a href="/logout">Logout</a></li>
		</ul>
		<ul id="userinfo_major">
			<li class="brackets"><strong><a href="/torrents/upload">Upload</a></strong></li>
			<li class="brackets"><strong><a href="/user/invite">Invite (<?= $user['invites'] ?>)</a></strong></li>
		</ul>
		<ul id="userinfo_stats">
			<li>Up: <span class="stat"><?= $display['upload'] ?></span></li>
			<li>Down: <span class="stat"><?= $display['download'] ?></span></li>
			<li id="ratiopipe"> | </li>
			<li>Ratio: <span class="stat"><?= $display['ratio'] ?></span></li>
			<li>(<a href="kb.php?id=5">required</a>: <span class="stat">--</span>)</li>
			<li id="ratiopipe"> | </li>
			<li>Points: <span class="stat"><a href="exchange.php"><?= number_format($user['points']) ?></a></span></li>
		</ul>
		<ul id="userinfo_minor">
			<li><a href="/inbox">Inbox</a></li>
			<li><a href="#">Uploads</a></li>
			<li><a href="/bookmarks">Bookmarks</a></li>
			<li><a href="/user/notify">Notifications</a></li>
			<li><a href="#">Posts</a></li>
			<li><a href="/friends">Friends</a></li>
		</ul>
	</div>
	<div id="menu">
		<ul>
			<li id="nav_index"><a href=".">Home</a></li>
			<li id="nav_torrents"><a href="torrents/view">Torrents</a></li>
			<li id="nav_requests"><a href="requests/view">Requests</a></li>
			<li id="nav_forums"><a href="forums">Forums</a></li>
			<li id="nav_top10"><a href="top10">Top&nbsp;10</a></li>
			<li id="nav_rules"><a href="#">Rules</a></li>
			<li id="nav_kb"><a href="kb">Knowledge&nbsp;Base</a></li>
			<li id="nav_staff"><a href="staff">Staff</a></li>
			<li id="nav_tickets"><a href="tickets">Tickets</a></li>
			<li id="nav_chat"><a href="chat">Chat</a></li>
		</ul>
	</div>
	<div id="alerts">
	</div>
	<div id="searchbars">
		<ul>
			<li><form action="#"><input type="text" name="search" placeholder="Torrents"><input value="Search" type="submit" class="hidden"></form></li>
			<li><form action="#"><input type="text" name="search" placeholder="Requests"><input value="Search" type="submit" class="hidden"></form></li>
			<li><form action="#"><input type="text" name="search" placeholder="Forums"><input value="Search" type="submit" class="hidden"></form></li>
			<li><form action="#"><input type="text" name="search" placeholder="Users"><input value="Search" type="submit" class="hidden"></form></li>
		</ul>
	</div>
</div>
<div id="content">
