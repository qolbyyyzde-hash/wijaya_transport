<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Payments</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>Payments</h1>
    <p><a href="/wijaya_transport/admin.php">← Dashboard</a></p>
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;background:#111;color:#fff">
      <thead><tr><th>ID</th><th>Booking</th><th>Car</th><th>Amount</th><th>Method</th><th>Status</th><th>Transaction ID</th><th>Date</th></tr></thead>
      <tbody>
        <?php foreach($payments as $p): ?>
        <tr>
          <td><?=htmlspecialchars($p['id'])?></td>
          <td><?=htmlspecialchars($p['booking_id'])?></td>
          <td><?=htmlspecialchars(($p['brand']??'').' '.($p['model']??''))?></td>
          <td>Rp <?=number_format($p['amount'],0,',','.')?></td>
          <td><?=htmlspecialchars($p['payment_method'])?></td>
          <td><?=htmlspecialchars($p['status'])?></td>
          <td><?=htmlspecialchars($p['transaction_id'])?></td>
          <td><?=htmlspecialchars($p['payment_date'])?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
