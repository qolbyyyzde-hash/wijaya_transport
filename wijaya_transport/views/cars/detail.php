<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Car Detail</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <a href="/wijaya_transport/index.php?page=cars" style="color:#fff">← Back</a>
    <h1><?=htmlspecialchars($car['brand'].' '.$car['model'])?></h1>
    <?php if(!empty($car['image'])): ?><img src="/wijaya_transport/<?=htmlspecialchars($car['image'])?>" style="width:100%;max-height:420px;object-fit:cover;margin-bottom:12px"><?php endif; ?>
    <p>Year: <?=htmlspecialchars($car['year'])?> | Plate: <?=htmlspecialchars($car['plate_number'])?></p>
    <p>Price per day: Rp <?=number_format($car['price_per_day'],0,',','.')?></p>

    <h2>Book this car</h2>
    <form action="/wijaya_transport/controllers/booking_controller.php" method="post">
      <input type="hidden" name="car_id" value="<?=htmlspecialchars($car['id'])?>">
      <div><label>Name<input name="name" required></label></div>
      <div><label>Phone<input name="phone"></label></div>
      <div><label>Start Date<input type="date" name="start_date" required></label></div>
      <div><label>End Date<input type="date" name="end_date" required></label></div>
      <div style="margin-top:12px"><button class="btn btn-accent" type="submit">Confirm Booking</button></div>
    </form>
  </div>
</body>
</html>
