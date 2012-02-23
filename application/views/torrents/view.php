<div class="thin">
	<h2><?= $torrent['name']; ?></h2>
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
				<li id="tag_<?= $tag ?>">
					<?= form_open('/torrents/tag', array('id' => 'tag_delete_'.$tag), array('action' => 'delete', 'id' => $torrent['id'], 'tag' => $tag)); ?>
					<a href="#"><?= str_replace('.', ' ', $tag) ?></a>
					<?= ($can_delete_tags) ? '<a href="javascript:$(\'#tag_delete_<?= $tag ?>\').submit();">[X]</a>' : ''; ?>
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
				<td class="sign"><img src="/static/common/icons/snatched.png" alt="Snatches" title="Snatches"></td>
				<td class="sign"><img src="/static/common/icons/seeders.png" alt="Seeders" title="Seeders"></td>
				<td class="sign"><img src="/static/common/icons/leechers.png" alt="Leechers" title="Leechers"></td>
			</tr>
			<tr class="group_torrent">
				<td class="center"><a href="#"><img src="/static/common/category/<?= $categories[$torrent['category']]['icon']; ?>" alt="<?= $categories[$torrent['category']]['name']; ?>" title="<?= $categories[$torrent['category']]['name']; ?>" width="24" height="24"></a></td>
				<td>
					<span>[<a href="/torrents/download/<?= $torrent['id']; ?>" title="Download">DL</a>&nbsp;|&nbsp;<a href="#" title="Report">RP</a>]</span>
					<?= $torrent['name']; ?>
				</td>
				<td><?= number_format(count($torrent['files'])); ?></td>
				<td><?= $ci->utility->format_bytes($torrent['size']); ?></td>
				<td><?= number_format($torrent['snatched']); ?></td>
				<td><?= number_format($torrent['seeders']); ?></td>
				<td><?= number_format($torrent['leechers']); ?></td>
			</tr>
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
		
		<?php if(count($comments) > $per_page): ?>
			<div class="linkbox">
				<?= $ci->utility->get_page_nav('/torrents/view/'.$torrent['id'].'/', $page,  count($comments), $per_page); ?>
			</div>
		<?php endif; ?>

		<?php
			foreach($comments as $c) {
				echo $ci->utility->generate_post($c['owner'], $c['id'], $c['time'], $c['body']);
			}
		?>
		
		<h3>Reply</h3>
		<div class="box pad" style="padding:20px 10px 10px 10px;">
			<form id="quickpostform" action="" method="post" style="display: block; text-align: center;">
				<div id="quickreplypreview" class="box" style="text-align: left; display: none; padding: 10px;"></div>
				<div id="quickreplytext">
					<input type="hidden" name="action" value="reply" />
					<input type="hidden" name="thread" value="193" />
					<textarea id="quickpost" name="body"  style="width:100%" rows="8"></textarea> <br />
				</div>
				<div id="quickreplybuttons">
					<input type="button" value="Toggle Visual" onclick="tinyMCE.execCommand('mceToggleEditor',false,'quickpost');" />

					<input type="button" value="Preview" onclick="Quick_Preview();" />
					<input type="submit" value="Submit reply" />
				</div>
			</form>
		</div>
	</div>
</div>		
