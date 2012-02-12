		<table class="border left">
			<tr>
				<td class="label">Torrent file</td>
				<td><input id="file" type="file" name="file_input"></td>
			</tr>
			<tr>
				<td class="label">Category</td>
				<td>
					<select id="categories_upload" name="type" onchange="load_form(this.value);">
					<?php for($i = 0; $i < count($categories); $i++) {
						echo "\t\t\t\t\t\t<option value=\"".$i."\" ".($i == $categoryID ? "SELECTED" : "").">".$categories[$i]['name']."</option>\n";
					} ?>
					</select>
				</td>
			</tr>
			<?php
				foreach($category['metadata'] as $m) {
					$data = $metadata[$m];
			?>
			<tr>
				<td class="label"><?= $data['display']; ?></td>
				<td></td>
			</tr>
			<?php } ?>
			<tr id="title_row">
				<td class="label">Title</td>
				<td><input type="text" name="title" size="60"></td>
			</tr>
			<tr>
				<td class="label">Description</td>
				<td><textarea name="description" cols="60" rows="6"></textarea></td>
			</tr>
			<tr>
				<td class="label">Image (optional)</td>
				<td><input type="text" name="image" size="60"></td>
			</tr>
		</table>
