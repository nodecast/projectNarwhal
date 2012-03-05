<table class="forum_post box vertical_margin" id="post'.$id.'">
  <tr class="colhead_dark">
    <td colspan="2">
      <span style="float:left;">
        <a href="#post<?= $id ?>">#<?= $id ?></a>
        by <strong><?= $user['username'] ?></strong>
          <span title="<?= $ci->utility->time_diff_string($time) ?>"><?= $ci->utility->time_diff_string($time) ?></span> - <a href="#quickpost" onclick="">[Quote]</a>
      </span>
      <span id="bar<?= $id ?>" style="float:right;"></span>
    </td>
  </tr>
  <tr>
    <td class="avatar" valign="top">
      <img src="<?= $user['avatar'] ?>" width="150" alt="<?= $user['username'] ?>'s avatar" />
    </td>
    <td class="body" valign="top">
      <div id="content<?= $id ?>">
        <?= $ci->textformat->parse($body, $this->config->item('torrent_cache')) ?>
      </div>
    </td>
  </tr>
</table>