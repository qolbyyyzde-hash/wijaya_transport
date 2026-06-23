<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Car</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <?php include __DIR__ . '/../_nav.php'; ?>
    <h1>Edit Car</h1>
    <form action="/wijaya_transport/admin.php?module=cars&action=update" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?=htmlspecialchars($car['id'])?>">
      <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
      <div><label>Brand<input name="brand" value="<?=htmlspecialchars($car['brand'])?>"></label></div>
      <div><label>Model<input name="model" value="<?=htmlspecialchars($car['model'])?>"></label></div>
      <div><label>Year<input name="year" value="<?=htmlspecialchars($car['year'])?>"></label></div>
      <div><label>Plate Number<input name="plate_number" value="<?=htmlspecialchars($car['plate_number'])?>"></label></div>
      <div><label>Price per day<input name="price_per_day" value="<?=htmlspecialchars($car['price_per_day'])?>"></label></div>
      <div><label>Image<input type="file" name="image"></label></div>
      <?php if(!empty($car['image'])): ?><div>Current: <img src="/wijaya_transport/<?=htmlspecialchars($car['image'])?>" style="height:48px"></div><?php endif; ?>
      <div><label>Status<select name="status"><option value="available" <?=($car['status']==='available'?'selected':'')?>>Available</option><option value="unavailable" <?=($car['status']==='unavailable'?'selected':'')?>>Unavailable</option></select></label></div>
      <div><button type="submit">Update</button></div>
    </form>
  </div>
</body>
</html>
