<div class="thin">
	<h2><?= htmlspecialchars($torrent['name']); ?></h2>
	<div class="linkbox">
		<a href="#">[Edit]</a>
		<a href="#">[Bookmark]</a>
	</div>

	<div class="sidebar">
		<?php if($torrent['image']) { ?>
		<div class="box">
			<div class="head"><strong>Image</strong></div>
			<p align="center"><a href="<?= $torrent['image'] ?>" target="_blank"><img src="<?= $torrent['image'] ?>" width="220" alt="<?= $torrent['name'] ?>" title="<?= $torrent['name'] ?>" border="0" /></a></p>

		</div>
		<?php } ?>
		<div class="box">
			<div class="head"><strong>Tags</strong></div>
			<ul class="stats nobullet" id="tags">
<?php foreach($torrent['tags'] as $tag): ?>
				<li id="tag_<?= md5($tag) ?>">
					<?= form_open('/torrents/tag', array('id' => 'tag_delete_'.md5($tag)), array('action' => 'delete', 'id' => $torrent['id'], 'tag' => htmlspecialchars($tag))); ?>
					<a href="#"><?= htmlspecialchars($tag) ?></a>
					<?= ($can_delete_tags) ? '<a href="javascript:$(\'#tag_delete_'.md5($tag).'\').submit();">[X]</a>' : ''; ?>
					</form>
				</li>
<?php endforeach; ?>
			</ul>
		</div>
		<?php if($can_add_tags): ?>
		<div class="box">
			<div class="head"><strong>Add tag</strong></div>
			<div class="body center">
				<?= form_open('/torrents/tag', '', array('action' => 'add', 'id' => $torrent['id'])); ?>
					<input type="text" name="tag"><br>
					<input type="submit" name="submit" value="+">
				</form>
			</div>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="main_column">
		<table class="torrent_table">
			<tr class="colhead">
				<td class="small"></td>
				<td width="100%">Name</td>
				<td>Files</td>
				<td class="stat">Size</td>
				<td class="sign"><img src="<?= $static_server; ?>/common/icons/snatched.png" alt="Snatches" title="Snatches"></td>
				<td class="sign"><img src="<?= $static_server; ?>/common/icons/seeders.png" alt="Seeders" title="Seeders"></td>
				<td class="sign"><img src="<?= $static_server; ?>/common/icons/leechers.png" alt="Leechers" title="Leechers"></td>
			</tr>
			<tr class="group_torrent">
				<td class="center"><a href="#"><img src="<?= $static_server; ?>/common/category/<?= $categories[$torrent['category']]['icon']; ?>" alt="<?= $categories[$torrent['category']]['name']; ?>" title="<?= $categories[$torrent['category']]['name']; ?>" width="24" height="24"></a></td>
				<td>
					<span>[<a href="/torrents/download/<?= $torrent['id']; ?>" title="Download">DL</a>&nbsp;|&nbsp;<a href="#" title="Report">RP</a>]</span>
					<?= htmlspecialchars($torrent['name']); ?>
				</td>
				<td><?= number_format(count($torrent['files'])); ?></td>
				<td><?= $ci->utility->format_bytes($torrent['size']); ?></td>
				<td><?= number_format($torrent['snatched']); ?></td>
				<td><?= number_format($torrent['seeders']); ?></td>
				<td><?= number_format($torrent['leechers']); ?></td>
			</tr>
		<?php if(count($torrent['metadata'])): // heh?>
			<tr>
				<td colspan="7">
					<table class="border left">
						<tr class="colhead">
							<td class="stat">Name</td>
							<td width="100%">Value</td>
						</tr>
						<?php foreach($torrent['metadata'] as $key => $val):
							$schema = $ci->config->item('metadata');
							$schema = $schema[$key];
							
							if($schema['type'] == 0) {
								$display = implode('<br>', $val);
							}
							if($schema['type'] == 1) {
								$enum = array();
								foreach($val as $v) {
									$enum[] = $schema['enum'][$v];
								}
								$display = implode('<br>', $enum);
							}
							if($schema['type'] == 2) {
								$display = ($val[0]) ? '<span class="check">&#10004;</span>' : '<span class="x">&#10008;</span>';
							}
						?>
						<tr>
							<td class="metadata left"><strong><?= $schema['display']; ?></strong></td>
							<td class="metadata left"><?= $display; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
		<?php endif; ?>
			<tr>
				<td colspan="7">
					<blockquote>
						Ratio after download: <?= $ci->utility->ratio($user['upload'], $user['download'] + $torrent['size']); ?><br>
						Uploaded by <a href="/user/view/<?= $owner['id']; ?>"><?= $owner['username']; ?></a> on <span title="<?= $ci->utility->time_diff_string($torrent['time']); ?>"><?= $ci->utility->format_datetime($torrent['time']); ?></span>
					</blockquote>
					<div class="center">
						<a href="javascript:;" onclick="$('#filelist').fadeToggle('fast', 'swing');">Show/Hide Filelist</a>
						<blockquote id="filelist">
							<table style="overflow-x:auto;">
								<tr class="colhead_dark"><td><strong>File Name</strong></td><td><strong>Size</strong></td></tr>
								<?php foreach($torrent['files'] as $file): ?>
									<tr><td><?= $file['name'] ?></td><td><?= $ci->utility->format_bytes($file['size']); ?></td></tr>
								<?php endforeach; ?>
							</table>
						</blockquote>
						<br>
						<a href="javascript:;" onclick="loadPeerlist(); $('#peerlist').fadeToggle('fast', 'swing');">Show/Hide Peerlist</a>
						<blockquote id="peerlist">
						</blockquote>
						<script type="text/javascript">
							var peerlistLoaded = false;
							function loadPeerlist() {
								if(!peerlistLoaded) {
									$.get('/ajax/peerlist/<?= $torrent['id'] ?>', function(data) {
										$('#peerlist').html(data);
									});
									peerlistLoaded = true;
								}
							}
							
							$('#filelist').hide();
							$('#peerlist').hide();
						</script>
					</div>
				</td>
			</tr>
		</table>
		
		<div class="box">
			<div class="head"><strong>Info</strong></div>
			<div class="body">
			<?= $ci->textformat->parse($torrent['description']); ?>
			</div>
		</div>
		
		<?php if($results > $per_page): ?>
			<div class="linkbox">
				<?= $ci->utility->get_page_nav('/torrents/view/'.$torrent['id'].'/', $page,  $results, $per_page); ?>
			</div>
		<?php endif; ?>

		<?php foreach($comments as $c) { ?>
			<?php
				$c['user'] = $user;
			?>
			<? $this->load->view("partials/post", $c); ?>
		<?php } ?>
		
		<h3>Reply</h3>
		<?= validation_errors(); ?>
		<div class="box pad" style="padding:20px 10px 10px 10px;display: block; text-align: center;">
			<?= form_open('/torrents/view/'.$torrent['id']); ?>
				<div id="quickreplytext" class="center">
					<input type="hidden" name="action" value="reply">
					<textarea id="quickpost" name="text" style="width:90%" rows="8"></textarea><br>
				</div>
				<div id="quickreplybuttons">
					<input type="submit" value="Submit">
				</div>
			</form>
		</div>
	</div>
</div>		
