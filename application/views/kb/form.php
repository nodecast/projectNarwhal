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
        <td><input name="name" id="kb_name" size="80" value="<?= (isset($name))? htmlspecialchars($name) : "" ?>" /></td>
      </tr>
      <tr>
        <td class="label">Content</td>
        <td><textarea id="body" name="bb_src" cols="80" rows="20"><?= (isset($bb_src))? htmlspecialchars($bb_src) : "" ?></textarea></td>
      </tr>
    </table>

    <div class="center box pad">
        Before creating a KB article make sure that one does not exist on the topic, and that it is suitable for the KB.
        <br><br>
        <input id="post" type="submit" value="Save KB Article">
        <input id="preview_button" name="preview" type="button" value="Preview KB Article">
    </div>
  </form>
</div>

<div id="preview_post">
  <h3>Preview</h3>
  <div class="box">
    <div class="head" id="preview_name"></div>
    <div class="pad" id="preview_box">
      
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#preview_post').hide();
  $('#preview_button').click(function(){
    $('#preview_box').html('<h3>Loading...</h3>');
    $('#preview_post').show();
    $.post(
      '/ajax/preview/',
      {body: $('#body').val(), fancy: true},
      function(responseText){
        $('#preview_box').html(responseText);
        $('#preview_name').html($('#kb_name').val());
        document.location='#preview_post';
      },
      "html"
    );
  });
</script>
