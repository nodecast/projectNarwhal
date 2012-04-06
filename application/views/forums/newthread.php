<h2 class="center"><a href="/forums/">Forums</a> &gt; <a href="/forums/view_forum/<?= $forum['_id']; ?>"><?= $forum['name']; ?></a> &gt; New Thread</h2>

<?= validation_errors(); ?>
<div class="head center">New Thread</div>
<div class="box center">
	<?= form_open('/forums/new_thread/'.$forum['_id']); ?>
		<table>
			<tr>
				<td><div class="label">Title:&nbsp;&nbsp;</div></td>
				<td><input type="text" size="80" name="title"></td>
			</tr>
			<tr>
				<td><div class="label">Body:&nbsp;&nbsp;</div></td>
				<td><textarea name="body" rows="10" cols="80"></textarea></td>
			</tr>
		</table>
		<div class="pad">
			<input type="submit" name="submit" value="Send">
		</div>
	</form>
</div>
