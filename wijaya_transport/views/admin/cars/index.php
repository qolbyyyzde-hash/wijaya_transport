<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Cars</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <?php include __DIR__ . '/../_nav.php'; ?>
    <h1>Cars</h1>
    <p><a href="/wijaya_transport/admin.php?module=cars&action=new">Add New Car</a></p>
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;background:#111;color:#fff">
      <thead><tr><th>ID</th><th>Brand</th><th>Model</th><th>Year</th><th>Price/Day</th><th>Image</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach($cars as $c): ?>
        <tr>
          <td><?=htmlspecialchars($c['id'])?></td>
          <td><?=htmlspecialchars($c['brand'])?></td>
          <td><?=htmlspecialchars($c['model'])?></td>
          <td><?=htmlspecialchars($c['year'])?></td>
          <td><?=htmlspecialchars($c['price_per_day'])?></td>
          <td><?php if(!empty($c['image'])): ?><img src="/wijaya_transport/<?=htmlspecialchars($c['image'])?>" alt="" style="height:48px"><?php endif;?></td>
          <td>
            <a href="/wijaya_transport/admin.php?module=cars&action=edit&id=<?=$c['id']?>">Edit</a> |
            <form method="post" action="/wijaya_transport/admin.php?module=cars&action=delete" style="display:inline;margin:0;padding:0" onsubmit="return confirm('Delete?')">
              <input type="hidden" name="id" value="<?=htmlspecialchars($c['id'])?>">
              <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
              <button type="submit" style="background:none;border:none;color:#f88;cursor:pointer;padding:0;margin:0">Delete</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
