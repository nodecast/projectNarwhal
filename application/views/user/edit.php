<h3>Edit <a href="/users/view/<?= $user['id'] ?>"><?= $user['username'] ?></a>'s profile</h3>

<?= validation_errors(); ?>
<div class="upload center">
  <?= form_open('user/edit/'.$user['id']) ?>
    <div id="upload_table">
    </div>

    <table class="border left">
      <tr>
        <td class="label">Email</td>
        <td><input name="email" size="60" value="<?= $user['email'] ?>" /></td>
      </tr>
      <tr>
        <td class="label">Download torrents as text files?</td>
        <td><input name="download_as_txt" type="checkbox" <?= ($user['settings']['download_as_txt'])? "checked" : "" ?> /></td>
      </tr>
    </table>

    <div class="center box pad">
        <input id="post" type="submit" value="Save Profile">
    </div>
  </form>
</div>
