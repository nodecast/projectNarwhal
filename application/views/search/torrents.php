<div class="box center">
  <span><?= number_format($resp['numFound']); ?> torrent(s) found</span>
</div>

<table class="torrents_table" id="torrents_table">
  <tr class="colhead">
    <td style="width:100%;">
      Name
    </td>
  </tr>
  <?php if ($resp['numFound'] > 0) { foreach($resp['docs'] as $torrent) { ?>
  <tr class="user">
    <td><a href="/torrents/view/<?= $torrent['_id'] ?>" title="View Torrent"><?= htmlspecialchars($torrent['name']) ?></a></td>
  </tr>
  <?php } } ?>
</table>

<?php if($resp['numFound'] == 0) { // Articles not found ?>
<div class="box pad center">
  <h2>No torrents found.</h2>
</div>
<?php } ?>