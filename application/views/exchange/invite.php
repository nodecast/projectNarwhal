<h3>Buy an Invite</h3>

<?= validation_errors(); ?>
<div class="upload center">
  <?= form_open('/exchange/invite') ?>
    <div id="upload_table">
    </div>

    <table class="border left">
      <tr>
        <td class="label">Amount</td>
        <td>
          <input type="number" min="1" max="100" name="amount" size="10" value="<?= set_value('amount') ?>" />
          Invites (10,000 BP per invite)
        </td>
      </tr>
    </table>

    <div class="center box pad">
        Buying invites is final! There are <em>no</em> refunds!
        <br><br>
        <input id="post" type="submit" value="Buy Invite(s)" />
    </div>
  </form>
</div>