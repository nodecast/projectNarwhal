<h3>Transfer BP</h3>

<?= validation_errors(); ?>
<div class="upload center">
  <?= form_open('/exchange/transfer') ?>
    <div id="upload_table">
    </div>

    <?php if (isset($target)) { ?>
      <input type="hidden" name="username" value="<?= set_value('username') ?>" />
      <input type="hidden" name="amount" value="<?= set_value('amount') ?>" />
    <?php } else { ?>

    <table class="border left">
      <tr>
        <td class="label">Username</td>
        <td>
          <input type="text" name="username" size="20" value="<?= set_value('username') ?>" />
        </td>
      </tr>
      <tr>
        <td class="label">Amount</td>
        <td>
          <input type="number" min="1" name="amount" size="10" value="<?= set_value('amount') ?>" />
          BP (20% Tax)
        </td>
      </tr>
    </table>

    <?php } ?>

    <div class="center box pad">
    <?php if (isset($target)) { ?>
      Transferring BP is final! There are <em>no</em> refunds!
      <br><br>
      <p>You will transfer <?= intval(set_value('amount') * 0.80) ?> BP to
        <a href="/user/view/<?= $target['_id'] ?>" target="_blank"><?= $target['username'] ?></a>.</p>
      <img src="<?= $target['avatar'] ?>" />
      <br><br>
      <input name="confirm" id="post" type="submit" value="Confirm Transfer" />
    <?php } else { ?>
      <input id="post" type="submit" value="Verify Transfer" />
    <?php } ?>
    </div>
  </form>
</div>