<?= validation_errors(); ?>
<div class="head center">Register</div>
<div class="box center">
	<br>
	<strong>Sorry. This site is currently invite only.</strong><br>
	If you have an invite code, please enter it below:<br>
	<?= form_open('register', 'class="body"'); ?>
		<input type="text" name="code">
		<input type="submit" name="invite_submit" value="Register">
	</form>
</div>
