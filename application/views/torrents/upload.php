<?= validation_errors(); ?>
<div class="upload center">
	<p>
		Your personal announce url is:
		<br>
		<input type="text" value="" size="71">
	</p>
	<?= form_open_multipart('torrents/upload/') ?>
		<div id="upload_table">
		</div>

		<script type="text/javascript">
			function load_form(id) {
				$("#upload_table").html("<h2>Retrieving Form...</h2>").load("/ajax/upload_form/" + id);
			}
			load_form(0);
		</script>

		<div class="center box pad">
				Be sure that your torrent is approved by the <a href="rules.php?p=upload">rules</a>. Not doing this will result in a <strong>warning</strong> or <strong>worse</strong>.
				<br>
				After uploading the torrent, you will have a one hour grace period during which no one other than you can fill requests with this torrent. Make use of this time wisely, and search the requests.
				<br><br>
				<input id="post" type="submit" value="Upload torrent">
		</div>
	</form>
</div>
