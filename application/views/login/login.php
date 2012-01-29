<html>

<head>
<title>Login</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>

<body>

<div id="header"></div> <div id="logo"></div>
<div id="menu"></div>
<div id="content">

<center>
<div class="head">Login</div>
</center>

<div class="box">
<form action="" method="POST" class="body" >
<?= $error ?><br>

<table>

<tr>
<td>
<center>
<div class="label">Username:&nbsp;&nbsp;
<input type="text" name="username"></div></td>
</center>
</tr>

<tr>
<td>
<center>
<div class="label">Password:&nbsp;&nbsp;
<input type="password" name="password"></div>
</center>
</td>
</tr>

</table>

<?php if($redirect) { echo '<input type="hidden" name="redirect" value="'.$redirect.'">'; }?><br>

<center>
<input type="submit" name="submit" value="Login">
</center>

</div>

</form>
</div>
<div id="footer"> </div>
</body>
</html>
