<h3>Edit <a href="/users/view/<?= $user['_id'] ?>"><?= $user['username'] ?></a>'s profile</h3>

<?= validation_errors(); ?>
<div class="upload center">
  <?= form_open('user/edit/'.$user['_id']) ?>
    <div id="upload_table">
    </div>

    <table class="border left">
      <tr>
        <td class="label">Email</td>
        <td><input name="email" size="60" value="<?= $user['email'] ?>" /></td>
      </tr>
      <tr>
        <td class="label">Avatar</td>
        <td>
          <input name="avatar" size="60" value="<?= $user['avatar'] ?>" /><br />
          <span class="smallinfo">
            Avatars <em>must</em> be <strong>safe for work</strong>!
          </span>
        </td>
      </tr>
      <tr>
        <td class="label">IRC Key</td>
        <td>
          <input name="irc_key" size="60" value="<?= $user['irc_key'] ?>" /><br />
          <span class="smallinfo">
            This is your NickServ password on IRC. Your registered nickname is your <?= $this->config->item('site_name') ?> username (<?= $user['username'] ?>).
            This password is stored in <b>plain text</b> and as such, you should not use any of your other passwords here.
            Only letters and numbers are allowed.
          </span>
        </td>
      </tr>
      <tr>
        <td class="label">Paranoia</td>
        <td>
          <select name="paranoia">
            <option value="0" <?= ($user['paranoia'] == 0)? "selected" : "" ?> >0 - Standard (Nothing Hidden)</option>
            <option value="1" <?= ($user['paranoia'] == 1)? "selected" : "" ?> >1 - Hidden: Seeding, Leeching.</option>
            <option value="2" <?= ($user['paranoia'] == 2)? "selected" : "" ?> >2 - Hidden: Seeding, Leeching, Snatched.</option>
            <option value="3" <?= ($user['paranoia'] == 3)? "selected" : "" ?> >3 - Hidden: Seeding, Leeching, Snatched, Uploaded.</option>
            <option value="4" <?= ($user['paranoia'] == 4)? "selected" : "" ?> >4 - Hidden: Seeding, Leeching, Snatched, Uploaded, Stats.</option>
            <option value="5" <?= ($user['paranoia'] == 5)? "selected" : "" ?> >5 - Tinfoil Hat (Everything Hidden)</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="label">Download torrents as text files?</td>
        <td>
          <input name="download_as_txt" type="checkbox" <?= ($user['settings']['download_as_txt'])? "checked" : "" ?> />
          <span class="smallinfo">(check this if your ISP blocks torrents)</span>
        </td>
      </tr>
    </table>

    <div class="center box pad">
        <input id="post" type="submit" value="Save Profile">
    </div>
  </form>
</div>
