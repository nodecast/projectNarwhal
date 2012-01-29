<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>

<body>

<?= validation_errors(); ?>
<?= form_open('register'); ?>

<div id="header"> </div><div id="logo"></div>
<div id="menu"></div>

<div id="content">
<center>
<div class="head">Registration</div>
</center>

<div class="box">

<form action="" method="POST" class="body" >
<?= $error ?><br>

<table>

<tr>
<td>
<div class="label">Desired Username:;</div>
</td>
<td><input type="text" name="username" value="<?= set_value('username') ?>"></td>
</tr>

<tr>
<td>
<div class="label">Email:</div>
</td>
<td><input type="text" name="email" value="<?= set_value('email') ?>"></td>
</tr>


<tr>
<td>
<div class="label">Password:</div>
</td>
<td><input type="password" name="password"></td>
</tr>

<tr>
<td>
<div class="label">Verify Password:</div>
</td>
<td><input type="password" name="passconf"></td>
</tr>


<tr>
<td>
<div class="label">I will read the rules</div>
</td>
<td><input type="checkbox" name="rules" value="rules" <?= set_checkbox("rules", "rules"); ?> ></td>
</tr>

<tr>
<td>
<div class="label">I am 13 years of age or older.</div>
</td>
<td><input type="checkbox" name="age" value="age" <?= set_checkbox("age", "age"); ?> ></td>
</tr>


</table>


<center>
<br><input type="submit" name="submit" value="Register">
</center>

</div>

</form>

</div>
<div id="footer"> </div>
</body>
</html>
