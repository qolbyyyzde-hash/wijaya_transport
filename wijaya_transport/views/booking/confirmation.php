<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Confirmation</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <style>
    *,*::before,*::after{box-sizing:border-box}
    body{background:#06070b;color:#f8fafc;min-height:100vh;height:auto;margin:0;padding:0;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif}
    .invoice-shell{padding:110px 24px 3rem;max-width:980px;margin:0 auto 3rem auto;position:relative;overflow:hidden;min-height:100vh}
    .invoice-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:blur(28px) brightness(.6) contrast(1.1);transform:scale(1.15);z-index:0}
    .invoice-overlay{position:absolute;inset:0;background:radial-gradient(circle at 80% 20%, rgba(15,23,42,0.4) 0%, rgba(5,7,10,0.85) 100%);z-index:1}
    .invoice-card{position:relative;z-index:2;background:rgba(22,25,35,0.8);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.1);box-shadow:0 24px 48px rgba(0,0,0,.3);border-radius:28px;padding:32px;}
    .invoice-card h2{margin:0 0 20px;color:#ffffff;font-size:1.5rem}
    .invoice-summary{display:grid;grid-template-columns:repeat(2,minmax(180px,1fr));gap:18px;}
    .invoice-summary div{background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:18px;padding:22px}
    .invoice-summary div strong{display:block;font-size:.82rem;text-transform:uppercase;letter-spacing:.15em;color:#94a3b8;margin-bottom:10px;font-weight:700}
    .invoice-summary div span{display:block;color:#ffffff;font-size:1rem;line-height:1.6;word-break:break-word;font-weight:600}
    .section-panel{background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:24px;padding:28px;margin-top:32px}
    .section-panel h2{margin:0 0 16px;color:#ffffff;font-size:1.35rem}
    .section-panel p{margin:0 0 18px;color:#cbd5e1;line-height:1.8}
    .section-panel ul{margin:0 0 24px;padding-left:20px;color:#cbd5e1;line-height:1.85}
    .section-panel li{margin-bottom:12px}
    .qris-box{display:flex;align-items:flex-start;gap:20px;margin-bottom:24px;background:rgba(255,255,255,0.03);padding:20px;border-radius:16px;border:1px solid rgba(255,255,255,0.08);flex-wrap:wrap}
    .qris-code-wrap{background:#ffffff;padding:10px;border-radius:12px;display:inline-block;flex-shrink:0}
    .qris-code-wrap img{width:120px;height:120px;object-fit:contain;display:block}
    .qris-content{flex:1 1 200px;min-width:0;max-width:100%}
    .qris-tag{font-size:11px;color:#f59e0b;font-weight:800;text-transform:uppercase;letter-spacing:1px}
    .qris-title{font-size:16px;font-weight:800;color:#ffffff;margin:4px 0}
    .qris-desc{font-size:13px;color:#94a3b8;margin:0;line-height:1.5;word-break:break-word}
    .form-group{margin-bottom:20px}
    .form-group label{display:block;margin-bottom:10px;color:#e2e8f0;font-weight:700;font-size:.95rem}
    .form-group input[type=file],.form-group textarea{width:100%;border:1px solid rgba(255,255,255,0.14);background:rgba(255,255,255,0.05);color:#ffffff;border-radius:14px;padding:14px;font-size:1rem;outline:none;transition:border-color .2s ease,box-shadow .2s ease}
    .form-group input[type=file]::file-selector-button{background:#f59e0b;color:#000;font-weight:700;border:none;border-radius:10px;padding:8px 12px;cursor:pointer}
    .form-group input[type=file]:focus,.form-group textarea:focus{border-color:#f59e0b;box-shadow:0 0 0 4px rgba(245,158,11,.16)}
    .form-group textarea{min-height:130px;resize:vertical}
    .back-link{display:inline-flex;margin-bottom:20px;color:#cbd5e1;font-weight:700;text-decoration:none;letter-spacing:.02em;transition:color .2s ease,transform .2s ease}
    .back-link:hover{color:#f59e0b;transform:translateX(-2px)}
    .btn-submit{display:inline-flex;align-items:center;justify-content:center;padding:14px 24px;border-radius:999px;border:none;background:linear-gradient(135deg, #f59e0b 0%, #d97706 100%);color:#000000;font-size:1rem;font-weight:800;cursor:pointer;transition:transform .18s ease,box-shadow .18s ease}
    .btn-submit:hover{transform:translateY(-1px);box-shadow:0 18px 35px rgba(245,158,11,.28)}
    .muted{color:#94a3b8;font-size:.96rem;margin-top:24px;max-width:760px}
    .receipt-box{margin-top:24px;backdrop-filter:blur(16px);background:rgba(30,35,48,0.75);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:24px;color:#ffffff;margin-bottom:24px;}
    .receipt-box h2{color:#ffffff;font-size:18px;font-weight:800;margin:0 0 16px 0}
    .receipt-box .row{display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid rgba(255,255,255,0.1);color:#cbd5e1;font-size:14px;gap:12px;}
    .receipt-box .row:last-child{border-bottom:none}
    .receipt-box .row span:last-child{color:#ffffff;font-weight:600}
    .receipt-box .total-row{display:flex;justify-content:space-between;align-items:center;padding-top:18px;margin-top:18px;font-size:14px;font-weight:800;color:#f59e0b;border-top:1px solid rgba(255,255,255,0.1);}
    @media(max-width:720px){.invoice-card{padding:24px}.invoice-summary{grid-template-columns:1fr}.invoice-shell{padding:30px 16px 60px}.qris-box{flex-direction:column;align-items:flex-start}.qris-code-wrap{margin-bottom:4px}} 
  </style>
</head>
<body>
  <div class="invoice-shell">
    <img src="/wijaya_transport/assets/media/temerario.jpg" alt="Background Blur" class="invoice-bg">
    <div class="invoice-overlay"></div>
    <?php
      $startDate = new DateTime($booking['start_date']);
      $endDate = new DateTime($booking['end_date']);
      $rentalDays = max(1, $startDate->diff($endDate)->days);
      $dailyPrice = (float)$booking['price_per_day'];
      $rentalSubtotal = $dailyPrice * $rentalDays;
      $driverSelected = strtolower(trim($booking['driver_option'] ?? '')) === 'dengan sopir';
      $pickupSelected = strtolower(trim($booking['pickup_option'] ?? '')) === 'diantar ke lokasi';
      $driverFee = $driverSelected ? 150000 * $rentalDays : 0;
      $pickupFee = $pickupSelected ? 50000 : 0;
      $computedTotal = $rentalSubtotal + $driverFee + $pickupFee;
    ?>
    <div class="invoice-card">
      <div style="margin-bottom:32px;">
        <a href="/wijaya_transport/index.php?page=cars" class="back-link" style="color:#cbd5e1;text-decoration:none;font-size:14px;font-weight:600;display:inline-flex;align-items:center;gap:8px;margin-bottom:16px;">← Kembali ke Katalog Mobil</a>
        <h1 style="margin:8px 0 12px 0;font-size:32px;font-weight:800;letter-spacing:-0.5px;color:#ffffff;">Invoice Pembayaran</h1>
        <p style="margin:0;color:#94a3b8;font-size:15px;line-height:1.6;max-width:600px;">Booking Anda telah dibuat. Silakan lakukan pembayaran sesuai metode yang dipilih, lalu unggah bukti transfer untuk verifikasi admin.</p>
      </div>
      <?php
        $paymentStatus = strtolower(trim($booking['status_pembayaran'] ?? $booking['payment_status'] ?? $booking['status'] ?? 'pending'));
        if ($paymentStatus === '') {
            $paymentStatus = 'pending';
        }
        $isPaidOrCompleted = in_array($paymentStatus, ['paid', 'completed', 'lunas'], true);
      ?>
      <div class="invoice-summary">
        <div><strong>Booking ID</strong><span><?=htmlspecialchars($booking['id'])?></span></div>
        <div><strong>Status</strong><span><?=htmlspecialchars(ucfirst($booking['status']))?></span></div>
        <div><strong>Mobil</strong><span><?=htmlspecialchars($booking['brand'].' '.$booking['model'])?></span></div>
        <div><strong>Periode</strong><span><?=htmlspecialchars($booking['start_date'])?> → <?=htmlspecialchars($booking['end_date'])?></span></div>
        <div><strong>Nama</strong><span><?=htmlspecialchars($booking['customer_name'] ?? $booking['name'] ?? '-')?></span></div>
        <div><strong>Nomor WA</strong><span><?=htmlspecialchars($booking['customer_phone'] ?? $booking['phone'] ?? $booking['whatsapp'] ?? '-')?></span></div>
        <div><strong>Metode Pembayaran</strong><span><?=htmlspecialchars($booking['payment_method'] ?? 'N/A')?></span></div>
        <div><strong>Layanan Sewa</strong><span><?=htmlspecialchars($booking['driver_option'] ?? '-')?></span></div>
        <div><strong>Metode Pengambilan</strong><span><?=htmlspecialchars($booking['pickup_option'] ?? '-')?></span></div>
        <div><strong>Status Pembayaran</strong><span><?=htmlspecialchars(ucfirst($paymentStatus))?></span></div>
        <div style="grid-column:1/ -1"><strong>Total Harga</strong><span>Rp <?=number_format($computedTotal,0,',','.')?></span></div>
      </div>
      <div class="receipt-box">
        <h2>Nota Pembayaran</h2>
        <div class="row"><span>Harga Sewa Mobil (x <?= $rentalDays ?> Hari)</span><span>Rp <?= number_format($rentalSubtotal,0,',','.') ?></span></div>
        <?php if($driverSelected): ?>
          <div class="row"><span>Opsi Sopir</span><span>+ Rp <?= number_format(150000 * $rentalDays,0,',','.') ?> / hari</span></div>
        <?php endif; ?>
        <?php if($pickupSelected): ?>
          <div class="row"><span>Biaya Pengantaran Unit</span><span>+ Rp <?= number_format($pickupFee,0,',','.') ?></span></div>
        <?php endif; ?>
        <div class="total-row">
          <span>TOTAL YANG HARUS DIBAYAR</span>
          <span>Rp <?= number_format($computedTotal,0,',','.') ?></span>
        </div>
      </div>

      <?php
        $proofPath = !empty($booking['proof_image']) ? $booking['proof_image'] : (!empty($booking['bukti_transfer']) ? $booking['bukti_transfer'] : null);
      ?>
      <?php if ($isPaidOrCompleted): ?>
        <div style="margin-top: 24px; padding: 24px; background-color: #dcfce7; border: 1px solid #22c55e; border-radius: 24px;">
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
            <span style="font-size:1.65rem;">🎉</span>
            <h2 style="margin:0;font-size:1.35rem;color:#166534;">Pembayaran Berhasil & Terverifikasi!</h2>
          </div>
          <p style="margin:0 0 12px 0;color:#14532d;line-height:1.8;font-size:1rem;">
            Terima kasih, pembayaran Anda telah diverifikasi oleh admin. Pemesanan mobil Anda telah dikonfirmasi.
          </p>
          <p style="margin:0;color:#14532d;line-height:1.8;font-size:.95rem;">
            Silakan simpan/cetak halaman invoice ini atau tunjukkan kepada petugas saat pengambilan/pengantaran armada.
          </p>
        </div>
      <?php elseif (!empty($proofPath) && $paymentStatus === 'pending'): ?>
        <div style="margin-top: 24px; padding: 20px; background-color: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <span style="display: inline-block; color: #059669; font-weight: bold; font-size: 18px; line-height: 1;">✓</span>
                <h4 style="margin: 0; font-weight: 700; color: #065f46; font-size: 16px;">Bukti transfer berhasil diunggah</h4>
            </div>
            <p style="margin: 0 0 8px 0; font-size: 13px; color: #047857; line-height: 1.5;">
                Bukti transfer Anda telah berhasil dikirim. Menunggu verifikasi admin.
            </p>
            <?php if(!empty($proofPath)): ?>
              <div style="margin-top:16px; border-radius:18px; overflow:hidden; max-width:320px; border:1px solid rgba(15,23,42,.08);">
                <img src="/wijaya_transport/<?=htmlspecialchars(ltrim($proofPath, '/'))?>" alt="Pratinjau Bukti Transfer" style="width:100%; height:auto; display:block;">
              </div>
            <?php endif; ?>
        </div>
      <?php endif; ?>

    <?php if (!$isPaidOrCompleted && empty($proofPath) && $paymentStatus === 'pending'): ?>
    <section class="section-panel">
      <h2>Instruksi Pembayaran</h2>
      <p>Pilih salah satu metode di bawah ini, lalu unggah bukti transfer untuk konfirmasi cepat.</p>
      <?php
        $paymentMethod = strtolower((string)($booking['payment_method'] ?? ''));
        if ($paymentMethod === 'bca' || $paymentMethod === 'transfer bca') {
      ?>
        <div class="p-5 bg-blue-50 border border-blue-200 rounded-2xl">
          <span class="inline-block px-3 py-1 bg-blue-600 text-white text-[10px] font-bold rounded-full uppercase tracking-wider mb-2">Transfer Bank BCA</span>
          <p class="text-xs text-blue-900 mb-1">Silakan transfer sesuai nominal total harga ke rekening berikut:</p>
          <div class="bg-white p-3 rounded-xl border border-blue-200 mt-2">
            <p class="text-xs text-stone-500 font-medium">Bank BCA</p>
            <p class="text-lg font-bold text-stone-900 tracking-wider">123-456-7890</p>
            <p class="text-xs text-stone-600">a.n. Wijaya Transport</p>
            <p class="mt-3 text-sm text-stone-800">Nominal yang harus dibayar: <strong>Rp <?=number_format($computedTotal,0,',','.')?></strong></p>
          </div>
        </div>
      <?php } elseif ($paymentMethod === 'mandiri' || $paymentMethod === 'transfer mandiri') { ?>
        <div class="p-5 bg-amber-50 border border-amber-200 rounded-2xl">
          <span class="inline-block px-3 py-1 bg-amber-600 text-white text-[10px] font-bold rounded-full uppercase tracking-wider mb-2">Transfer Bank Mandiri</span>
          <p class="text-xs text-amber-900 mb-1">Silakan transfer sesuai nominal total harga ke rekening berikut:</p>
          <div class="bg-white p-3 rounded-xl border border-amber-200 mt-2">
            <p class="text-xs text-stone-500 font-medium">Bank Mandiri</p>
            <p class="text-lg font-bold text-stone-900 tracking-wider">987-654-3210</p>
            <p class="text-xs text-stone-600">a.n. Wijaya Transport</p>
            <p class="mt-3 text-sm text-stone-800">Nominal yang harus dibayar: <strong>Rp <?=number_format($computedTotal,0,',','.')?></strong></p>
          </div>
        </div>
      <?php } elseif ($paymentMethod === 'qris' || $paymentMethod === 'qr') { ?>
        <div class="qris-box">
          <div class="qris-code-wrap">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=WIJAYATRANSPORT_QRIS_PAYMENT" alt="QRIS Code">
          </div>
          <div class="qris-content">
            <span class="qris-tag">Scan QRIS</span>
            <h4 class="qris-title">Bayar Instan Lewat QRIS</h4>
            <p class="qris-desc">
              Buka aplikasi GoPay, OVO, Dana, ShopeePay, atau M-Banking Anda, lalu scan QR Code di samping untuk membayar.
            </p>
            <p style="margin: 12px 0 0; color: #f8fafc; font-weight: 700;">Nominal yang harus dibayar: <strong>Rp <?=number_format($computedTotal,0,',','.')?></strong></p>
          </div>
        </div>
      <?php } else { ?>
        <div class="p-4 bg-stone-50 rounded-2xl border border-stone-200 text-xs text-stone-600 space-y-2">
          <p>• <strong>BCA:</strong> 123-456-7890 a.n. Wijaya Transport</p>
          <p>• <strong>Mandiri:</strong> 987-654-3210 a.n. Wijaya Transport</p>
          <p>• <strong>QRIS:</strong> Scan QRIS di kasir/admin.</p>
          <p class="mt-2 text-stone-700">Nominal yang harus dibayar: <strong>Rp <?=number_format($computedTotal,0,',','.')?></strong></p>
        </div>
      <?php } ?>

      <form action="/wijaya_transport/controllers/payment_upload.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
        <input type="hidden" name="booking_id" value="<?=htmlspecialchars($booking['id'])?>">
        <div class="form-group"><label>Bukti Transfer / Pembayaran (jpg,png)</label><input type="file" name="bukti_transfer" accept="image/*" required></div>
        <div class="form-group"><label>Catatan Tambahan (opsional)</label><textarea name="note" rows="4"></textarea></div>
        <button type="submit" class="btn-submit">Unggah Bukti & Selesai</button>
      </form>
    </section>
    <?php endif; ?>
  </div>
</body>
</html>
