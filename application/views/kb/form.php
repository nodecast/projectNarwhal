<h3><?= $ucverb ?> KB Article</h3>

<?= validation_errors(); ?>
<div class="upload center">
  <?php if ($preview) { ?>
    <div class="smallinfo"><a href="#preview">(Preview below)</a></div>
  <?php } ?>

  <?= form_open($formurl) ?>
    <div id="upload_table">
    </div>

    <table class="border left">
      <tr>
        <td class="label">Name</td>
        <td><input name="name" size="60" value="<?= (isset($name))? htmlspecialchars($name) : "" ?>" /></td>
      </tr>
      <tr>
        <td class="label">Content</td>
        <td><textarea name="bb_src" cols="60" rows="30"><?= (isset($bb_src))? htmlspecialchars($bb_src) : "" ?></textarea></td>
      </tr>
    </table>

    <div class="center box pad">
        Before creating a KB article make sure that one does not exist on the topic, and that it is suitable for the KB.
        <br><br>
        <input id="post" type="submit" value="Save KB Article">
        <input name="preview" type="submit" value="Preview KB Article">
    </div>
  </form>
</div>

<?php if ($preview) { ?>
  <h3>Preview</h3>

  <div class="box">
    <div class="head"><?= htmlspecialchars($name) ?></div>
    <div class="pad">
      <?= $preview ?>
    </div>
  </div>

<?php } ?>