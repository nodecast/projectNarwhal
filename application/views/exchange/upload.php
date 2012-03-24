<h3>Convert BP to Upload</h3>

<?= validation_errors(); ?>
<div class="upload center">
  <?= form_open('/exchange/upload') ?>
    <div id="upload_table">
    </div>

    <table class="border left">
      <tr>
        <td class="label">Amount</td>
        <td>
          <input type="number" min="1" max="1023" name="amount" size="10" value="<?= set_value('amount') ?>" />
          BP (1GiB per 1,000BP)
        </td>
      </tr>
    </table>

    <div class="center box pad">
        Converting points to upload is final! There are <em>no</em> refunds!
        <br><br>
        <input id="post" type="submit" value="Convert" />
    </div>
  </form>
</div>