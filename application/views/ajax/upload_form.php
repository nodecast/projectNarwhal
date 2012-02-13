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
			<tr id="title_row">
				<td class="label">Title</td>
				<td><input type="text" id="title" name="title" size="60"></td>
			</tr>
			<tr id="title_row">
				<td class="label">Tags</td>
				<td><input type="text" id="tags" name="tags" size="60"></td>
			</tr>
			<?php
				foreach($category['metadata'] as $key) {
					$data = $metadata[$key];
			?>
			<tr>
				<td class="label"><?= $data['display'].($data['required'] ? "" : " (optional)"); ?></td>
				<td>
					<?php
						switch($data['type']) {
							case 0: // *
								$field = '<input type="text" id="metadata-'.$key.'" size="60" name="metadata-'.$key.'[]">';
								echo "<div id=\"metadata-$key\">\n".$field."</div>\n";
								if($data['multiple']) {
									echo '<a href=\'javascript:;\' onclick=\'$("#metadata-'.$key.'").append("<input type=\"text\" size=\"60\" name=\"metadata-'.$key.'[]\"><br>")\'>Add another</a>';
								}
								break;
							case 1: // enum
								if($data['multiple'])
									echo '<i>Hold \'CTRL\' to select multiple values.</i><br>';
								echo '<select size="6" name="metadata-'.$key.'[]"'.($data['multiple'] ? ' multiple >' : ' >');
								foreach($data['enum'] as $option) {
									echo '<option value="'.$option.'">'.$option.'</option>';
								}
								echo '</select>';
								break;
							case 2: // true/false
								echo '<input type="checkbox" id="metadata-'.$key.'" name="metadata-'.$key.'" value="true">';
								break;
						}
					?>
					</div>
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td class="label">Description</td>
				<td><textarea name="description" id="description" cols="60" rows="6"></textarea></td>
			</tr>
			<tr>
				<td class="label">Image (optional)</td>
				<td><input type="text" id="image" name="image" size="60"></td>
			</tr>
		</table>
