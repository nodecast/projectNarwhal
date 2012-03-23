<h3>The Exchange</h3>

<table class="exchange_table">
  <thead>
    <tr class="head dark colhead">
      <th class="action">Action</th>
      <th class="price">Price</th>
      <th class="tax">Tax</th>
      <th class="title">Title</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $name => $item) { ?>
      <tr>
        <td><a href="/exchange/<?= $name ?>"><?= $item['action'] ?></a></td>
        <td><?= $item['price'] ?></td>
        <td><?= $ci->utility->format_percent($item['tax']) ?></td>
        <td><?= $item['title'] ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>