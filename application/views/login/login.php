<div class="head center">Login</div>
<div class="box">
	<form action="" method="POST" class="body">
	<?= $error ?><br>
		<table class="center">
			<tr>
				<td><div class="label">Username:&nbsp;&nbsp;<input type="text" name="username"></div></td>
			</tr>
			<tr>
				<td><div class="label">Password:&nbsp;&nbsp;<input type="password" name="password"></div></td>
			</tr>
		</table>
		<?php if($redirect) { echo '<input type="hidden" name="redirect" value="'.$redirect.'">'; }?>
		<div class="center">
			<input type="submit" name="submit" value="Login">
		</div>
	</form>
</div>


