<?= validation_errors(); ?>
<div class="head center">Registration</div>
<div class="box">
	<?= form_open('register', 'class="body"'); ?>

		<input type="hidden" name="code" value="<?= $code ?>">
		<table>
			<tr>
				<td><div class="label">Desired Username:</div></td>
				<td><input type="text" name="username" value="<?= set_value('username') ?>"></td>
			</tr>
			<tr>
				<td><div class="label">Email:</div></td>
				<td><input type="text" name="email" value="<?= set_value('email') ?>"></td>
			</tr>
			<tr>
				<td><div class="label">Password:</div></td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td><div class="label">Verify Password:</div></td>
				<td><input type="password" name="passconf"></td>
			</tr>
			<tr>
				<td><div class="label">I will read the rules</div></td>
				<td><input type="checkbox" name="rules" value="rules" <?= set_checkbox("rules", "rules"); ?> ></td>
			</tr>
			<tr>
				<td><div class="label">I am 13 years of age or older.</div></td>
				<td><input type="checkbox" name="age" value="age" <?= set_checkbox("age", "age"); ?>></td>
			</tr>
		</table>
		<div class="center"><input type="submit" name="reg_submit" value="Register"></div>
	</form>
</div>
