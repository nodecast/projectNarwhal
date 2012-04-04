<h3>Staff</h3>

<div class="staff_box">
  <?php foreach ($staff as $name => $class) { ?>
  <h4 class="left"><?= $name ?></h4>

  <table>
    <thead>
      <tr class="head dark colhead">
        <th width="30%">Name</th>
        <th>Last Seen</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($class as $u) { ?>
        <tr>
          <td><a href="/user/view/<?= $u['_id'] ?>"><?= $u['username'] ?></a></td>
          <td>
            <?php if ($u['paranoia'] >= 4) { ?>
              Hidden by staff member
            <?php } else { ?>
              <?= $this->utility->time_diff_string($u['lastaccess']) ?>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } ?>
</div>