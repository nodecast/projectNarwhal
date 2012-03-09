<div class="box center">
  <span><?= number_format($resp['numFound']); ?> user(s) found</span>
</div>

<table class="users_table" id="users_table">
  <tr class="colhead">
    <td style="width:100%;">
      Name
    </td>
  </tr>
  <?php if ($resp['numFound'] > 0) { foreach($resp['docs'] as $user) { ?>
  <tr class="user">
    <td><a href="/user/view/<?= $user['_id'] ?>" title="View User Profile"><?= htmlspecialchars($user['username']) ?></a></td>
  </tr>
  <?php } } ?>
</table>

<?php if($resp['numFound'] == 0) { // Articles not found ?>
<div class="box pad center">
  <h2>No users found.</h2>
</div>
<?php } ?>