<h3>Change Vhost</h3>

<?= validation_errors(); ?>
<div class="upload center">
  <?= form_open('/exchange/vhost') ?>
    <div id="upload_table">
    </div>

    <table class="border left">
      <tr>
        <td class="label">Vhost</td>
        <td>
          <input type="text" name="vhost" size="60" value="<?= set_value('vhost') ?>" />
          <br />
          <small>
            Vhosts can only use alphanumerics, dashes and periods.
          </small>
        </td>
      </tr>
    </table>

    <div class="center box pad">
        Changing your vhost is final! There are <em>no</em> refunds!
        <br><br>
        <input id="post" type="submit" value="Buy Vhost" />
    </div>
  </form>
</div>