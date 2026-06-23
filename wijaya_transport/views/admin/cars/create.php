<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Add Car</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <?php include __DIR__ . '/../_nav.php'; ?>
    <h1>Add New Car</h1>
    <form action="/wijaya_transport/admin.php?module=cars&action=create" method="post" enctype="multipart/form-data">
      <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
      <div><label>Brand<input name="brand" required></label></div>
      <div><label>Model<input name="model" required></label></div>
      <div><label>Year<input name="year" required></label></div>
      <div><label>Plate Number<input name="plate_number" required></label></div>
      <div><label>Price per day<input name="price_per_day" required></label></div>
      <div><label>Image<input type="file" name="image"></label></div>
      <div><label>Status<select name="status"><option value="available">Available</option><option value="unavailable">Unavailable</option></select></label></div>
      <div><button type="submit">Create</button></div>
    </form>
  </div>
</body>
</html>
