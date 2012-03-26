<?= validation_errors(); ?>
<div class="head center">New Message</div>
<div class="box center">
	<?= form_open('/messages/send/'); ?>
		<table>
			<tr>
				<td><div class="label">To:&nbsp;&nbsp;</div></td>
				<td><input type="text" size="50" name="to" value="<?= ($user ? $user : '') ?>"><br><em>Please seperate multiple recipients with commas.</em></td>
			</tr>
			<tr>
				<td><div class="label">Subject:&nbsp;&nbsp;</div></td>
				<td><input type="text" size="50" name="subject"></td>
			</tr>
			<tr>
				<td><div class="label">Body:&nbsp;&nbsp;</div></td>
				<td><textarea name="body" rows="10" cols="50"></textarea></td>
			</tr>
			<tr>
				<td><div class="label">Allow the invitation of users:&nbsp;&nbsp;</div></td>
				<td><input type="checkbox" name="private" value="true" checked="checked"></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Send">
	</form>
</div>
