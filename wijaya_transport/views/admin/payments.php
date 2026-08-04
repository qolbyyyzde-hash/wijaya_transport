<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Payments</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      background-color: #f8f6f0 !important;
      margin: 0 !important;
      padding: 0 !important;
      border: none !important;
      min-height: 100%;
    }

    body {
      color: #111111 !important;
    }

    body, h1, h2, p, th, td, label, a, button { color: #111111 !important; }
    .admin-shell { width: 100%; }
    .admin-heading { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .admin-heading h1 { margin: 0; font-size: 2rem; }
    .admin-subtitle { margin: 8px 0 0; color: #444444; max-width: 780px; line-height: 1.6; }
    .table-scroll { width: 100%; overflow-x: auto; }
    .admin-table { width: 100%; table-layout: auto; border-collapse: collapse; }
    .admin-table th, .admin-table td { padding: 10px 8px; vertical-align: middle; font-size: 0.92rem; }
    .admin-table thead th { background: #f1efe9; color: #111111; font-weight: 700; }
    .admin-table tbody tr { border-bottom: 1px solid #eee; }
    .admin-table tbody tr:last-child { border-bottom: none; }
    .admin-table tbody td { color: #333333; }
    .admin-badge { display: inline-flex; align-items: center; justify-content: center; padding: 6px 10px; border-radius: 999px; font-size: 0.85rem; font-weight: 700; }
    .admin-badge-paid { background: #e6f7ec; color: #166534; }
    .admin-badge-pending { background: #fdf2f8; color: #981b4d; }
    .admin-badge-cancelled { background: #f8d7da; color: #842029; }
    .thumb { max-width: 120px; width: 120px; height: auto; border-radius: 10px; object-fit: cover; }
    .actions { display: flex; flex-direction: column; gap: 8px; }
    .action-group { display: inline-flex; gap: 8px; flex-wrap: wrap; }
    .btn-confirm { background: #111111; color: #ffffff; padding: 8px 14px; border-radius: 8px; border: none; font-size: 13px; cursor: pointer; }
    .btn-confirm:hover { background: #333333; }
    .btn-ghost { display: inline-flex; align-items: center; justify-content: center; padding: 8px 14px; border-radius: 8px; border: 1px solid #d9d5cd; background: #ffffff; color: #111111; text-decoration: none; }
    .btn-ghost:hover { background: #f7f5f1; }
  </style>
</head>
<body>
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <header class="bg-white rounded-2xl p-4 px-8 mb-8 shadow-sm flex items-center justify-between">
        <div>
          <h1 class="font-bold text-lg text-stone-900 tracking-tight">WIJAYA TRANSPORT</h1>
          <p class="text-xs text-stone-500 font-medium">Admin Panel</p>
        </div>
        <nav class="flex items-center space-x-2 text-sm font-semibold">
          <a href="/wijaya_transport/admin.php?module=dashboard" class="px-5 py-2 text-stone-600 hover:text-stone-900 transition">Dashboard</a>
          <a href="/wijaya_transport/admin.php?module=cars" class="px-5 py-2 text-stone-600 hover:text-stone-900 transition">Cars</a>
          <a href="/wijaya_transport/admin.php?module=payments" class="px-5 py-2 bg-stone-900 text-white rounded-full transition" style="color: #ffffff !important;">Payments</a>
          <a href="/wijaya_transport/admin.php?module=auth&action=logout" class="px-5 py-2 text-stone-600 hover:text-stone-900 transition">Logout</a>
        </nav>
      </header>
      <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100 w-full">
        <div class="admin-heading">
          <div>
            <h1>Riwayat & Verifikasi Pembayaran</h1>
            <p class="admin-subtitle">Lihat status transaksi, bukti transfer, dan verifikasi pembayaran dengan cepat.</p>
          </div>
        </div>

        <div class="table-scroll pr-6">
          <table class="admin-table w-full text-sm border-collapse">
            <thead>
              <tr>
                <th class="whitespace-nowrap align-middle px-3 py-3">Booking ID</th>
                <th class="whitespace-nowrap align-middle px-3 py-3">Nama Pemesan</th>
                <th class="whitespace-nowrap align-middle px-3 py-3">Mobil</th>
                <th class="whitespace-nowrap align-middle px-3 py-3">Metode Pembayaran</th>
                <th class="whitespace-nowrap align-middle px-3 py-3">Total Biaya</th>
                <th class="whitespace-nowrap align-middle px-3 py-3">Bukti Transfer</th>
                <th class="whitespace-nowrap align-middle px-3 py-3">Status Pembayaran</th>
                <th class="whitespace-nowrap text-center align-middle px-3 py-3">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($payments as $p): ?>
              <?php
                $statusValue = $p['payment_status'] ?? $p['booking_status'] ?? 'pending';
                $statusLabel = ucfirst(strtolower((string)$statusValue));
                $statusClass = 'admin-badge-pending';
                if(in_array(strtolower((string)$statusValue), ['paid','settled','settlement'], true)) $statusClass = 'admin-badge-paid';
                if(in_array(strtolower((string)$statusValue), ['cancelled','cancel'], true)) $statusClass = 'admin-badge-cancelled';
                $paymentDate = htmlspecialchars($p['payment_date'] ?? '-');
                $paymentId = $p['payment_id'] ?? $p['booking_id'] ?? '-';
                $carLabel = trim((string)($p['brand'] ?? '') . ' ' . (string)($p['model'] ?? '')) ?: '-';
              ?>
              <tr>
                <td class="whitespace-nowrap align-middle"><?=htmlspecialchars($p['booking_id'] ?? '-')?></td>
                <td class="whitespace-nowrap align-middle"><?=htmlspecialchars($p['customer_name'] ?? '-')?></td>
                <td class="whitespace-nowrap align-middle"><?=htmlspecialchars(trim(($p['brand'] ?? '') . ' ' . ($p['model'] ?? '')) ?: '-')?></td>
                <td class="whitespace-nowrap align-middle px-3 py-3"><?=htmlspecialchars($p['payment_method'] ?? '-')?></td>
                <td class="whitespace-nowrap align-middle px-3 py-3">Rp <?=number_format($p['payment_amount'] ?? $p['amount'] ?? 0,0,',','.')?></td>
                <td class="whitespace-nowrap align-middle px-3 py-3">
                  <?php if(!empty($p['proof_image'])): ?>
                    <a href="/wijaya_transport/<?=htmlspecialchars($p['proof_image'])?>" target="_blank" class="btn-ghost">Lihat</a>
                  <?php else: ?>
                    —
                  <?php endif; ?>
                </td>
                <td class="whitespace-nowrap align-middle"><span class="admin-badge <?=$statusClass?>"><?=htmlspecialchars($statusLabel)?></span></td>
                <td class="text-center align-middle px-3 py-3">
                  <?php $currentStatus = strtolower((string)($p['payment_status'] ?? $p['booking_status'] ?? 'pending')); ?>
                  <div class="flex items-center justify-center whitespace-nowrap gap-2">
                    <?php if ($currentStatus === 'pending'): ?>
                      <a href="/wijaya_transport/admin.php?module=payments&action=paid&payment_id=<?=htmlspecialchars($p['payment_id'] ?? '')?>" 
                         class="inline-flex items-center justify-center px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-full shadow-sm transition-all whitespace-nowrap">
                          Konfirmasi Lunas
                      </a>
                    <?php elseif ($currentStatus === 'paid' || $currentStatus === 'lunas'): ?>
                      <a href="/wijaya_transport/admin.php?module=payments&action=cancel&payment_id=<?=htmlspecialchars($p['payment_id'] ?? '')?>" 
                         class="inline-flex items-center justify-center px-3 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold rounded-full border border-rose-200/60 transition-all whitespace-nowrap"
                         onclick="return confirm('Apakah Anda yakin ingin membatalkan status Lunas transaksi ini?')">
                          Batalkan Lunas
                      </a>
                    <?php else: ?>
                      <a href="/wijaya_transport/admin.php?module=payments&action=pending&payment_id=<?=htmlspecialchars($p['payment_id'] ?? '')?>" 
                         class="inline-flex items-center justify-center px-3 py-1 bg-stone-100 hover:bg-stone-200 text-stone-600 text-xs font-semibold rounded-full transition-all whitespace-nowrap">
                          Reset ke Pending
                      </a>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
  </main>
</body>
</html>
