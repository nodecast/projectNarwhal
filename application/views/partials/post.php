<table class="post box vertical_margin" id="post<?= $_id ?>" data-id="<?= $_id ?>">
  <tr class="colhead_dark">
    <td colspan="2">
      <span style="float:left;">
        <a href="#post<?= $_id ?>">Post</a>
        by <strong><?= $this->utility->format_name($owner); ?></strong>
          <span title="<?= $ci->utility->format_datetime($time) ?>"><?= $ci->utility->time_diff_string($time) ?></span> - <a href="#quickpost" class="quickpost">[Quote]</a>
      </span>
      <span id="bar<?= $_id ?>" style="float:right;"></span>
    </td>
  </tr>
  <tr>
    <td class="avatar" valign="top">
      <img src="<?= $owner_data['avatar'] ?>" width="150" alt="<?= $owner_data['username'] ?>'s avatar" />
    </td>
    <td class="body" valign="top">
      <div id="content<?= $_id ?>">
        <?= $ci->textformat->parse($body, $this->config->item('torrent_cache')) ?>
      </div>
    </td>
  </tr>
</table>
