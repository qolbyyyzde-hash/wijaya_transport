<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Payments</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <?php include __DIR__ . '/../_nav.php'; ?>
    <h1>Payments</h1>
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;background:#111;color:#fff">
      <thead><tr><th>ID</th><th>Booking</th><th>Car</th><th>Amount</th><th>Method</th><th>Status</th><th>Transaction ID</th><th>Date</th><th>Actions</th></tr></thead>
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
          <td>
            <form method="post" action="/wijaya_transport/admin.php?module=payments" style="display:inline">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="payment_id" value="<?=htmlspecialchars($p['id'])?>">
                <input type="hidden" name="status" value="settlement">
                <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
                <button type="submit" style="margin-right:6px">Mark Paid</button>
            </form>
            <form method="post" action="/wijaya_transport/admin.php?module=payments" style="display:inline">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="payment_id" value="<?=htmlspecialchars($p['id'])?>">
                <input type="hidden" name="status" value="cancel">
                <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
                <button type="submit">Cancel</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
