<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Confirmation</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="container">
    <h1>Booking Dikonfirmasi</h1>
    <p>Terima kasih, booking Anda telah diterima. Detail booking:</p>
    <ul>
      <li><strong>Booking ID:</strong> <?=htmlspecialchars($booking['id'])?></li>
      <li><strong>Mobil:</strong> <?=htmlspecialchars($booking['brand'].' '.$booking['model'])?></li>
      <li><strong>Tanggal:</strong> <?=htmlspecialchars($booking['start_date'])?> → <?=htmlspecialchars($booking['end_date'])?></li>
      <li><strong>Total Harga:</strong> Rp <?=number_format($booking['total_price'],0,',','.')?></li>
      <li><strong>Status:</strong> <?=htmlspecialchars($booking['status'])?></li>
    </ul>

    <p>
      <a class="btn btn-accent" id="toPay" href="/wijaya_transport/views/payment/checkout.php?booking_id=<?=htmlspecialchars($booking['id'])?>">Lanjut ke Pembayaran</a>
      <a class="btn btn-ghost" href="/wijaya_transport/index.php?page=cars">Kembali ke Daftar Mobil</a>
    </p>

    <script>
      // Auto-redirect to payment after 6 seconds (user can cancel by navigating away)
      (function(){
        var to = 6000; // ms
        setTimeout(function(){ window.location = document.getElementById('toPay').href; }, to);
      })();
    </script>

    <p class="muted">Kami juga mengirim catatan booking ke admin. Simpan ID booking untuk referensi.</p>
  </div>
</body>
</html>
