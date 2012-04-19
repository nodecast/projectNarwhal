<table class="post box vertical_margin" id="post<?= $_id ?>" data-id="<?= $_id ?>" data-owner="<?= $owner_data['username']; ?>">
  <tr class="colhead_dark">
    <td colspan="2">
      <span style="float:left;">
        <a href="#post<?= $_id ?>">Post</a>
        by <strong><?= $this->utility->format_name($owner); ?></strong>
          <span title="<?= $this->utility->format_datetime($time) ?>"><?= $this->utility->time_diff_string($time) ?></span> - <a href="#quickpost" id="btn-quickpost-<?= $_id ?>" class="quickpost">[Quote]</a><?= (isset($edit) && $edit) ? ' - <a href="javascript:;" class="editpost" id="btn-editpost-'.$_id.'" data-id="'.$_id.'">[Edit]</a>' : '' ?>
      </span>
      <span id="bar<?= $_id ?>" style="float:right;"></span>
    </td>
  </tr>
  <tr>
    <td class="avatar">
      <img src="<?= $owner_data['avatar'] ?>" width="150" alt="<?= $owner_data['username'] ?>'s avatar" />
    </td>
    <td class="body">
      <div id="content<?= $_id ?>">
      	<?= isset($html) ? $html : ''; ?>
        <?= $this->textformat->parse($body, $this->config->item('bbcode_cache')) ?>
        <?= (isset($lastedit) && count($lastedit)) ? '<div class="lastedit">Last edited by '.$this->utility->format_name($lastedit['owner']).' on '.$this->utility->format_datetime($lastedit['time']).'</div>' : ''?>
      </div>
    </td>
  </tr>
</table>
