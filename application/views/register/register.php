<html>
<head>
<title>Login</title>
</head>
<body>
<?= validation_errors(); ?>
<?= form_open('register'); ?>
Username: <input type="text" name="username" value="<?= set_value('username') ?>"><br>
Email: <input type="text" name="email" value="<?= set_value('email') ?>"><br>
Password: <input type="password" name="password"><br>
Verify Password: <input type="password" name="passconf"><br>
<input type="checkbox" name="rules" value="rules" <?= set_checkbox("rules", "rules"); ?>> I will read the rules.<br>
<input type="checkbox" name="age" value="age" <?= set_checkbox("age", "age"); ?>> I am 13 years of age or older.<br>
<br><input type="submit" name="submit" value="Register">
</form>
</body>
</html>
