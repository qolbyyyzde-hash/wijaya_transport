<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Form</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <div class="card booking-card">
      <h2>Booking Form</h2>
      <p class="muted">Pilih mobil dan isi detail booking Anda.</p>
      <form action="/wijaya_transport/controllers/booking_controller.php" method="post">
        <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">

        <div class="form-field">
          <label>Mobil</label>
          <select name="car_id" required>
            <option value="">-- pilih mobil --</option>
            <?php foreach($cars as $c): ?>
              <option value="<?=htmlspecialchars($c['id'])?>"><?=htmlspecialchars($c['brand'].' '.$c['model'].' (Rp '.number_format($c['price_per_day'],0,',','.').')')?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-field">
          <label>Nama</label>
          <input name="name" required>
        </div>

        <div class="form-field">
          <label>Email (opsional)</label>
          <input name="email" type="email">
        </div>

        <div class="form-field">
          <label>Telepon</label>
          <input name="phone">
        </div>

        <div class="form-field">
          <label>Tanggal Mulai</label>
          <input type="date" name="start_date" required>
        </div>

        <div class="form-field">
          <label>Tanggal Selesai</label>
          <input type="date" name="end_date" required>
        </div>

        <div class="form-actions">
          <button class="btn-confirm" type="submit">Confirm Booking</button>
          <a class="btn-ghost-light" href="/wijaya_transport/index.php?page=cars">Batal</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
