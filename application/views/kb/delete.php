<h3>Delete KB Article</h3>

<?= validation_errors(); ?>
<div class="upload center">
  <?= form_open('kb/delete/'.$article['id']) ?>
    <div id="upload_table">
    </div>

    <table class="border left">
      <tr>
        <td class="label">Are you sure?</td>
        <td><input type="checkbox" name="s1" /></td>
      </tr>
      <tr>
        <td class="label">Really sure?</td>
        <td><input type="checkbox" name="s2" /></td>
      </tr>
      <tr>
        <td class="label">Completely sure?</td>
        <td><input type="checkbox" name="s3" /></td>
      </tr>
    </table>

    <div class="center box pad">
        Do <em>not</em> delete a KB article without first consulting the staff and allowing them to reach a consensus.
        <br><br>
        <input id="post" type="submit" value="Delete KB Article">
    </div>
  </form>
</div>
