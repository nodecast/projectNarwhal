<html>
<head>
<title>Login</title>
</head>
<body>
<form action="" method="POST">
<?= $error ?><br>
Username: <input type="text" name="username"><br>
Password: <input type="password" name="password"><br>
<?php if($redirect) { echo '<input type="hidden" name="redirect" value="'.$redirect.'">'; }?><br>
<input type="submit" name="submit" value="Login">
</form>
</body>
</html>
