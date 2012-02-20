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
			<ul class="stats nobullet">
				<?php foreach($torrent['tags'] as $tag): ?>
				<li>
					<a href="#"><?= str_replace('.', ' ', $tag) ?></a>
					<a href="#">[X]</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="box">
			<div class="head"><strong>Add tag</strong></div>
			<div class="body center">
				<?php
				// TODO this
				?>
			</div>
		</div>
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
					<span>[<a href=#" title="Download">DL</a>&nbsp;|&nbsp;<a href="#" title="Report">RP</a>]</span>
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
						<a href="javascript:;" onclick="$('#filelist').fadeToggle('fast', 'swing')">Show/Hide Filelist</a>
						<blockquote id="filelist">
							awefawef
							awefawef<br>
							awefajweoguij<br>
							awiejfaowejfoi<br>
							wef
						</blockquote>
						
						<br>
						<br>
						
						<a href="javascript:;" >Show/Hide Peerlist</a>
						<div id="peerlist" class="box">
						</div>
					</div>
				</td>
			</tr>

			<tr class="pad hide" id="torrent_194">
				<td colspan="6">
										<div class="linkbox"><a href="torrents.php?id=193&amp;torrentid=194&amp;peers=194#peers_194">[Show/hide peer list]</a></div>


					<table style="overflow-x:auto;"><tr class="colhead_dark"><td><strong>File Name</strong></td><td><strong>Size</strong></td></tr><tr><td>DupeDB.com.txt</td><td>298.00 B</td></tr><tr><td>lap-moon.avi</td><td>700.84 MB</td></tr></table>

				</td>
			</tr>
		</table>
		<div class="box">
			<div class="head"><strong>Torrent info</strong></div>
			<div class="body"><u><strong>Moon (2009)</strong></u><br />
<br />
<strong>Genres:</strong>	Drama | Mystery | Sci-Fi | Thriller<br />

<br />
<strong>Director:</strong>	Duncan Jones<br />
<strong>Country:</strong>	UK<br />
<strong>Runtime:</strong> 97 min<br />
<strong>Rating:</strong>	8.0/10<br />

<strong>Outline:</strong>	Astronaut Sam Bell has a quintessentially personal encounter toward the end of his three-year stint on the Moon, where he, working alongside his computer, GERTY, sends back to Earth parcels of a resource that has helped diminish our planet&#39;s power problems.<br />
<br />
<strong>Cast:</strong>	Sam Rockwell | Sam Bell<br />
Kevin Spacey | GERTY (voice)<br />
Dominique McElligott | Tess Bell<br />
Rosie Shaw | Little Eve<br />
<br />

<strong>Mediainfo</strong> Wrote: <blockquote><br />
General<br />
Format                           : AVI<br />
Format/Info                      : Audio Video Interleave<br />
File size                        : 701 MiB<br />
Duration                         : 1h 32mn<br />
Overall bit rate                 : 1 055 Kbps<br />
Writing application              : VirtualDubMod 1.5.10.2 (build 2540/release)<br />

Writing library                  : VirtualDubMod build 2540/release<br />
<br />
Video<br />
ID                               : 0<br />
Format                           : MPEG-4 Visual<br />
Format profile                   : Advanced Simple@L5<br />
Format settings, BVOP            : Yes<br />
Format settings, QPel            : No<br />
Format settings, GMC             : No warppoints<br />

Format settings, Matrix          : Default (H.263)<br />
Muxing mode                      : Packed bitstream<br />
Codec ID                         : XVID<br />
Codec ID/Hint                    : XviD<br />
Duration                         : 1h 32mn<br />
Bit rate                         : 908 Kbps<br />
Width                            : 592 pixels<br />
Height                           : 240 pixels<br />
Display aspect ratio             : 2.467<br />

Frame rate                       : 25.000 fps<br />
Resolution                       : 8 bits<br />
Colorimetry                      : 4:2:0<br />
Scan type                        : Progressive<br />
Bits/(Pixel*Frame)               : 0.256<br />
Stream size                      : 603 MiB (86%)<br />
Writing library                  : XviD 1.2.1 (UTC 2008-12-04)<br />
<br />
Audio<br />

ID                               : 1<br />
Format                           : MPEG Audio<br />
Format version                   : Version 1<br />
Format profile                   : Layer 3<br />
Mode                             : Joint stereo<br />
Format_Settings_ModeExtension    : MS Stereo<br />
Codec ID                         : 55<br />
Codec ID/Hint                    : MP3<br />
Duration                         : 1h 32mn<br />

Bit rate mode                    : Variable<br />
Bit rate                         : 134 Kbps<br />
Minimum bit rate                 : 32.0 Kbps<br />
Channel(s)                       : 2 channels<br />
Sampling rate                    : 48.0 KHz<br />
Stream size                      : 88.9 MiB (13%)<br />
Alignment                        : Aligned on interleaves<br />
Interleave, duration             : 24 ms (0.60 video frame)<br />
Interleave, preload duration     : 215 ms<br />

Writing library                  : LAME3.98 <br />
Encoding settings                : -m j -V 4 -q 0 -lowpass 17.5 --vbr-new -b 32<br />
</blockquote></div>
		</div>
		<div class="linkbox"><strong>1-10</strong> | <a href="torrents.php?page=2&amp;id=193"><strong>11-20</strong></a> | <a href="torrents.php?page=3&amp;id=193"><strong>21-30</strong></a> | <a href="torrents.php?page=2&amp;id=193"><strong>Next &gt;</strong></a> <a href="torrents.php?page=3&amp;id=193"><strong> Last &gt;&gt;</strong></a></div>

<table class="forum_post box vertical_margin" id="post199">
	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post199'>#199</a>
			by <strong><a href="user.php?id=1765">protell</a><img src="static/common/symbols/disabled.png" alt="Banned" /> (User)</strong>
			  
<span title="Dec 27 2009, 13:15">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('199','protell');">[Quote]</a>

			</span>
			<span id="bar199" style="float:right;"></span>
		</td>
	</tr>
	<tr>
		<td class="avatar" valign="top">
			<img src="static/common/avatars/default.png" width="150" alt="Default avatar" />
		</td>
		<td class="body" valign="top">

			<div id="content199">
				great movie, thanks.			</div>
		</td>
	</tr>
</table>
<table class="forum_post box vertical_margin" id="post421">
	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post421'>#421</a>

			by <strong><a href="user.php?id=2502">LeNoir</a><img src="static/common/symbols/disabled.png" alt="Banned" /> (User)</strong>
			  
<span title="Dec 28 2009, 04:37">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('421','LeNoir');">[Quote]</a>
			</span>
			<span id="bar421" style="float:right;"></span>
		</td>

	</tr>
	<tr>
		<td class="avatar" valign="top">
			<img src="http://imgur.com/YP0Vi.jpg" width="150" alt="LeNoir's avatar" />
		</td>
		<td class="body" valign="top">
			<div id="content421">
				Good quality. Thanks.			</div>

		</td>
	</tr>
</table>
<table class="forum_post box vertical_margin" id="post427">
	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post427'>#427</a>
			by <strong><a href="user.php?id=257">yayorbitgum</a><img src="static/common/symbols/disabled.png" alt="Banned" /> (User)</strong>

			  
<span title="Dec 28 2009, 04:51">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('427','yayorbitgum');">[Quote]</a>
			</span>
			<span id="bar427" style="float:right;"></span>
		</td>
	</tr>
	<tr>
		<td class="avatar" valign="top">

			<img src="static/common/avatars/default.png" width="150" alt="Default avatar" />
		</td>
		<td class="body" valign="top">
			<div id="content427">
				Downloading based off of interesting synopsis and two good reviews (above)! :]			</div>
		</td>
	</tr>
</table>
<table class="forum_post box vertical_margin" id="post450">

	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post450'>#450</a>
			by <strong><a href="user.php?id=1480">ToastyMallows</a><img src="static/common/symbols/disabled.png" alt="Banned" /> (User)</strong>
			  
<span title="Dec 28 2009, 07:20">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('450','ToastyMallows');">[Quote]</a>

			</span>
			<span id="bar450" style="float:right;"></span>
		</td>
	</tr>
	<tr>
		<td class="avatar" valign="top">
			<img src="http://imgur.com/NtqzL.jpg" width="150" alt="ToastyMallows's avatar" />
		</td>
		<td class="body" valign="top">

			<div id="content450">
				Wow what a great movie glad it&#39;s on here I always wanted to see it.			</div>
		</td>
	</tr>
</table>
<table class="forum_post box vertical_margin" id="post460">
	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post460'>#460</a>

			by <strong><a href="user.php?id=257">yayorbitgum</a><img src="static/common/symbols/disabled.png" alt="Banned" /> (User)</strong>
			  
<span title="Dec 28 2009, 09:14">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('460','yayorbitgum');">[Quote]</a>
			</span>
			<span id="bar460" style="float:right;"></span>
		</td>

	</tr>
	<tr>
		<td class="avatar" valign="top">
			<img src="static/common/avatars/default.png" width="150" alt="Default avatar" />
		</td>
		<td class="body" valign="top">
			<div id="content460">
				Just finished it... awesome. Everyone should definitely watch this.			</div>

		</td>
	</tr>
</table>
<table class="forum_post box vertical_margin" id="post489">
	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post489'>#489</a>
			by <strong><a href="user.php?id=1848">monolith</a> (Power User)</strong>

			  
<span title="Dec 28 2009, 14:34">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('489','monolith');">[Quote]</a>
			</span>
			<span id="bar489" style="float:right;"></span>
		</td>
	</tr>
	<tr>
		<td class="avatar" valign="top">

			<img src="http://imgur.com/xCQFL.jpg" width="150" alt="monolith's avatar" />
		</td>
		<td class="body" valign="top">
			<div id="content489">
				Great movie. Good quality rip too.			</div>
		</td>
	</tr>
</table>
<table class="forum_post box vertical_margin" id="post592">

	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post592'>#592</a>
			by <strong><a href="user.php?id=2026">hypnopixel</a><img src="static/common/symbols/disabled.png" alt="Banned" /> (User)</strong>
			  
<span title="Dec 29 2009, 01:41">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('592','hypnopixel');">[Quote]</a>

			</span>
			<span id="bar592" style="float:right;"></span>
		</td>
	</tr>
	<tr>
		<td class="avatar" valign="top">
			<img src="http://imgur.com/VoKRr.jpg" width="150" alt="hypnopixel's avatar" />
		</td>
		<td class="body" valign="top">

			<div id="content592">
				well done, thanx			</div>
		</td>
	</tr>
</table>
<table class="forum_post box vertical_margin" id="post613">
	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post613'>#613</a>

			by <strong><a href="user.php?id=3462">dewired</a><img src="static/common/symbols/disabled.png" alt="Banned" /> (User)</strong>
			  
<span title="Dec 29 2009, 02:35">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('613','dewired');">[Quote]</a>
			</span>
			<span id="bar613" style="float:right;"></span>
		</td>

	</tr>
	<tr>
		<td class="avatar" valign="top">
			<img src="http://vgchat.com/customavatars/avatar8397605_220.gif" width="150" alt="dewired's avatar" />
		</td>
		<td class="body" valign="top">
			<div id="content613">
				Great movie, great quality, will seed.  Thanks!			</div>

		</td>
	</tr>
</table>
<table class="forum_post box vertical_margin" id="post650">
	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post650'>#650</a>
			by <strong><a href="user.php?id=685">ad1nf1n1tum</a><img src="static/common/symbols/disabled.png" alt="Banned" /> (User)</strong>

			  
<span title="Dec 29 2009, 05:06">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('650','ad1nf1n1tum');">[Quote]</a>
			</span>
			<span id="bar650" style="float:right;"></span>
		</td>
	</tr>
	<tr>
		<td class="avatar" valign="top">

			<img src="http://imgur.com/mV0h2.gif" width="150" alt="ad1nf1n1tum's avatar" />
		</td>
		<td class="body" valign="top">
			<div id="content650">
				Sick. Thank you.			</div>
		</td>
	</tr>
</table>
<table class="forum_post box vertical_margin" id="post704">

	<tr class="colhead_dark">
		<td colspan="2">
			<span style="float:left;"><a href='#post704'>#704</a>
			by <strong><a href="user.php?id=3967">CitizenSnips</a><img src="static/common/symbols/disabled.png" alt="Banned" /> (User)</strong>
			  
<span title="Dec 29 2009, 17:20">2 years, 1 month ago</span> - <a href="#quickpost" onclick="Quote('704','CitizenSnips');">[Quote]</a>

			</span>
			<span id="bar704" style="float:right;"></span>
		</td>
	</tr>
	<tr>
		<td class="avatar" valign="top">
			<img src="http://www.citizen-snips.com/images/csnips3-thumb.jpg" width="150" alt="CitizenSnips's avatar" />
		</td>
		<td class="body" valign="top">

			<div id="content704">
				Amazing movie, thanks!			</div>
		</td>
	</tr>
</table>
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

		<div class="linkbox"><strong>1-10</strong> | <a href="torrents.php?page=2&amp;id=193"><strong>11-20</strong></a> | <a href="torrents.php?page=3&amp;id=193"><strong>21-30</strong></a> | <a href="torrents.php?page=2&amp;id=193"><strong>Next &gt;</strong></a> <a href="torrents.php?page=3&amp;id=193"><strong> Last &gt;&gt;</strong></a></div>

	</div>
</div>		
