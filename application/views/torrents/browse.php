<?= form_open('/torrents/browse/'); ?>
	<div class="box pad">
		<script type="text/javascript">
			var num = -1;
			function changeInputType(id) {
				var metadata = $('#key_'+id).val();
				$("#input_"+id).html("Loading...").load("/ajax/search_field/" + metadata);
			}
			function addFilterField() {
				num++;
				return '<tr id="row_'+num+'"><td class="small"><a href="javascript:$(\'#row_'+num+'\').remove();void(0);">[x]</a><td class="key_select"><select name="key[]" id="key_'+num+'" class="large"><option value="title" selected onclick="changeInputType('+num+');">Title</option><option value="tags" onclick="changeInputType('+num+');">Tags</option><option value="category" onclick="changeInputType('+num+');">Category</option><?php foreach($cats as $cat): ?><optgroup label="<?= $cat['name']; ?>"><?php foreach($cat['metadata'] as $meta):$m = $metadata[$meta];?><option value="<?= $meta; ?>" onclick="changeInputType('+num+')"><?= $m['display'] ?></option><?php endforeach; ?></optgroup><?php endforeach; ?></select></td><td class="small"><select name="not[]"><option value="___" selected></option><option value="not">NOT</option></select></td><td id="input_'+num+'"><input type="text" name="data[]" size="60"></td></tr>';
			}
		</script>
		<table>
			<script type="text/javascript">document.write(addFilterField());</script>
			<tr id="filter_more"><td class="center" colspan="4"><a href="javascript:$('#filter_more').before(addFilterField);void(0);">Filter more</a></td></tr>
		</table>
		<div class="box pad submit center">
			<select name="match">
				<option value="and" selected>Match ALL</option>
				<option value="or">Match ANY</option>
			</select>
			<br>
			<input type="submit" value="Filter">
			<input type="button" value="Reset">
		</div>
	</div>
</form>
<div class="box center">
	<span><?= number_format($results); ?> torrent(s) found</span>
</div>

<?php if($results > $perpage) { ?>
<div class="linkbox">
	<?= $ci->utility->get_page_nav('/torrents/browse/', $page, $results, $perpage); ?>
</div>
<?php } ?>

<table class="torrent_table" id="torrent_table">
	<tr class="colhead">
		<td class="small"></td>
		<td style="width:100%;"><a href="#">Name</a></td>
		<td>Files</td>
		<td class="stat"><a href="#">Added</a></td>
		<td class="stat"><a href="#">Size</a></td>
		<td class="sign"><img src="<?= $static_server; ?>/common/icons/comments.png" alt="Comments" title="Comments"></td>
		<td class="sign"><a href="#"><img src="<?= $static_server; ?>/common/icons/snatched.png" alt="Snatches" title="Snatches"></a></td>
		<td class="sign"><a href="#"><img src="<?= $static_server; ?>/common/icons/seeders.png" alt="Seeders" title="Seeders"></a></td>
		<td class="sign"><a href="#"><img src="<?= $static_server; ?>/common/icons/leechers.png" alt="Leechers" title="Leechers"></a></td>
	</tr>
	<?php foreach($torrents as $torrent): ?>
	<tr class="torrent  ">
		<td class="center"><a href="#"><img src="<?= $static_server; ?>/common/category/<?= $categories[$torrent['category']]['icon']; ?>" alt="<?= $categories[$torrent['category']]['name']; ?>" title="<?= $categories[$torrent['category']]['name']; ?>" width="24" height="24"></a></td>
		<td>
			<span class="right">[<a href="/torrents/download/<?= $torrent['id']; ?>" title="Download">DL</a> | <a href="#" title="Report">RP</a>] </span>
			<a href="/torrents/view/<?= $torrent['id']; ?>" title="View Torrent"><?= $torrent['name']; ?></a>
			<?php if($torrent['freetorrent']) echo "[<strong>Freeleech!</strong>]"; ?>
			<br>
			<div class="tags">
				<?php foreach($torrent['tags'] as $tag): ?>
				<a href="/torrents/tag/<?= $tag ?>"><?= str_replace('.', ' ', $tag); ?></a>&nbsp;
				<?php endforeach; ?>
			</div>
		</td>
		<td><?= number_format(count($torrent['files'])); ?></td>
		<td><?= $ci->utility->time_diff_string($torrent['time']); ?></td>
		<td><?= $ci->utility->format_bytes($torrent['size']); ?></td>
		<td><?= number_format(count($torrent['comments'])); ?></td>
		<td><?= number_format($torrent['snatched']); ?></td>
		<td><?= number_format($torrent['seeders']); ?></td>
		<td><?= number_format($torrent['leechers']); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php
	if(count($torrents) == 0) {?>
	<div class="box pad center">
		<h2>No search results.</h2>
	</div>
<?php	}	?>
