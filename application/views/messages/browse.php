<div class="thin">
	<h2><?= $box['this']; ?></h2>
	<div class="linkbox">
		<a href="/messages/browse/<?= strtolower($box['other']); ?>/">[<?= $box['other']; ?>]</a><br>
		<?php if($results > $perpage) { ?>
			<!--<?= $ci->utility->get_page_nav('/messages/browse/'.strtolower($box['this']).'/', $page, $results, $perpage); ?>-->
		<?php } ?>
	</div>
	<div class="box pad">
		<form action="inbox.php" method="post" id="messageform">
			<input type="hidden" name="action" value="masschange" />
			<table>
				<tr class="colhead">
					<td width="10"><input type="checkbox" onclick="toggleChecks('messageform',this)" /></td>
					<td width="40%">Subject</td>
					<td>Sender</td>
					<td>Date</td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="27234" /></td>
					<td>
Sticky: 						<a href="inbox.php?action=viewconv&amp;id=27234">bB Invite Gmail</a>
					</td>
					<td><a href="user.php?id=10819">cook</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Feb 26 2012, 05:00">3 weeks, 14 hours ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="27148" /></td>
					<td>
Sticky: 						<a href="inbox.php?action=viewconv&amp;id=27148">Dear Interviewer</a>
					</td>
					<td><a href="user.php?id=7005">bandersnatch</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Feb 25 2012, 18:38">3 weeks, 1 day ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="24751" /></td>
					<td>
Sticky: 						<a href="inbox.php?action=viewconv&amp;id=24751">Stuff from the staff forum</a>
					</td>
					<td><a href="user.php?id=10920">Joshfryguy</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Jan 14 2012, 08:27">2 months, 3 days ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="29230" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=29230">One of your torrents has been deleted</a>
					</td>
					<td>System</td>
					<td><span title="Mar 18 2012, 03:16">16 hours and 13 minutes ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="28857" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=28857">Yo....</a>
					</td>
					<td><a href="user.php?id=15703">MR337</a></td>
					<td><span title="Mar 11 2012, 22:41">6 days, 20 hours ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="28484" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=28484">Incoming point transfer from funky_bougalou</a>
					</td>
					<td>System</td>
					<td><span title="Mar 07 2012, 19:03">1 week, 4 days ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="28115" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=28115">Goon</a>
					</td>
					<td><a href="user.php?id=16533">kalel</a></td>
					<td><span title="Mar 03 2012, 04:18">2 weeks, 1 day ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="28052" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=28052">Image white list...</a>
					</td>
					<td><a href="user.php?id=10615">c1010010</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Mar 02 2012, 21:59">2 weeks, 1 day ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="28031" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=28031">One of your torrents has been deleted</a>
					</td>
					<td>System</td>
					<td><span title="Mar 02 2012, 06:47">2 weeks, 2 days ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="27840" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=27840">adobe policy server de-drm help</a>
					</td>
					<td><a href="user.php?id=16412">paperowl666</a></td>
					<td><span title="Mar 01 2012, 00:58">2 weeks, 3 days ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="27553" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=27553">The request &quot;Predict the Oscar Winners Contest prize - Tix&quot; has been filled</a>
					</td>
					<td>System</td>
					<td><span title="Feb 27 2012, 06:43">2 weeks, 6 days ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="27272" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=27272">Your Music Info Site</a>
					</td>
					<td><a href="user.php?id=16292">Fertileland</a></td>
					<td><span title="Feb 27 2012, 06:36">2 weeks, 6 days ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="27278" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=27278">thanks</a>
					</td>
					<td><a href="user.php?id=16300">calder</a></td>
					<td><span title="Feb 26 2012, 07:07">3 weeks, 12 hours ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="27269" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=27269">Thank you for my invite!</a>
					</td>
					<td><a href="user.php?id=16291">SleepyB</a></td>
					<td><span title="Feb 26 2012, 06:30">3 weeks, 12 hours ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="27190" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=27190">hey, dude</a>
					</td>
					<td><a href="user.php?id=8948">space_flunky</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Feb 26 2012, 01:56">3 weeks, 17 hours ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="27061" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=27061">Is</a>
					</td>
					<td><a href="user.php?id=10920">Joshfryguy</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Feb 24 2012, 21:01">3 weeks, 1 day ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="26336" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=26336">Regarding your infinite ratio</a>
					</td>
					<td><a href="user.php?id=15835">rahl202</a></td>
					<td><span title="Feb 12 2012, 18:50">1 month, 4 days ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="26314" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=26314">test11</a>
					</td>
					<td><a href="user.php?id=3888">Eskimo</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Feb 12 2012, 05:16">1 month, 5 days ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="26292" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=26292">Is this you?</a>
					</td>
					<td><a href="user.php?id=6791">WakeUpSheeple</a></td>
					<td><span title="Feb 11 2012, 23:10">1 month, 5 days ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="26291" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=26291">Incoming point transfer from BroSanta</a>
					</td>
					<td>System</td>
					<td><span title="Feb 11 2012, 17:41">1 month, 5 days ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="25877" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=25877">test11</a>
					</td>
					<td><a href="user.php?id=12825">Caleb</a></td>
					<td><span title="Feb 05 2012, 07:59">1 month, 1 week ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="25876" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=25876">test11</a>
					</td>
					<td><a href="user.php?id=7005">bandersnatch</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Feb 05 2012, 07:59">1 month, 1 week ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="25875" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=25875">test11</a>
					</td>
					<td><a href="user.php?id=13584">Peeble</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Feb 05 2012, 07:59">1 month, 1 week ago</span></td>
				</tr>
				<tr class="rowa">
					<td class="center"><input type="checkbox" name="messages[]=" value="25607" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=25607">Rename</a>
					</td>
					<td><a href="user.php?id=5840">JudasRising420</a></td>
					<td><span title="Jan 31 2012, 22:14">1 month, 2 weeks ago</span></td>
				</tr>
				<tr class="rowb">
					<td class="center"><input type="checkbox" name="messages[]=" value="25515" /></td>
					<td>
						<a href="inbox.php?action=viewconv&amp;id=25515">HOLY SHIT</a>
					</td>
					<td><a href="user.php?id=13584">Peeble</a> <img src="static/common/symbols/bacon.gif" alt="Bacon" title="hoopy frood who really knows where his towe- er, bacon is" /></td>
					<td><span title="Jan 30 2012, 08:08">1 month, 2 weeks ago</span></td>
				</tr>
			</table>
			<input type="submit" value="Delete messages" />
		</form>
	</div>
	<div class="linkbox"><strong>1-25</strong> | <a href="inbox.php?page=2&amp;action=inbox"><strong>26-50</strong></a> | <a href="inbox.php?page=3&amp;action=inbox"><strong>51-75</strong></a> | <a href="inbox.php?page=4&amp;action=inbox"><strong>76-100</strong></a> | <a href="inbox.php?page=5&amp;action=inbox"><strong>101-101</strong></a> | <a href="inbox.php?page=2&amp;action=inbox"><strong>Next &gt;</strong></a> <a href="inbox.php?page=5&amp;action=inbox"><strong> Last &gt;&gt;</strong></a></div>
</div>
