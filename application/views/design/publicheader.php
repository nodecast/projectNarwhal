<!DOCTYPE HTML>
<html>
<head>
	<title>{title}</title>
	<link rel="stylesheet" href="<?= $static_server; ?>/styles/default/style.css" type="text/css" media="screen">
	<meta http-equiv="Content-Type" CONTENT="text/html; charset=utf-8">
</head>
<body>
<div id="header">
	<div id="logo"></div>
	<div id="menu">
		<ul>
			<li id="nav_home"><a href=".">Home</a></li>
			<li id="nav_login"><a href="login">Login</a></li>
			<?= ($open_reg) ? '<li id="nav_register"><a href="register">Register</a></li>' : '' ?>
		</ul>
	</div>
</div>
<div id="content">
