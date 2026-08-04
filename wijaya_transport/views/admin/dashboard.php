<?php
// Pastikan koneksi & query data ada
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f7f5f0] text-stone-800 font-sans min-h-screen">
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <header class="bg-white rounded-2xl p-4 px-8 mb-8 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="font-bold text-lg text-stone-900 tracking-tight">WIJAYA TRANSPORT</h1>
            <p class="text-xs text-stone-500 font-medium">Admin Panel</p>
        </div>
        <nav class="flex items-center space-x-2 text-sm font-semibold">
            <a href="/wijaya_transport/admin.php?module=dashboard" class="px-5 py-2 bg-stone-900 text-white rounded-full">Dashboard</a>
            <a href="/wijaya_transport/admin.php?module=cars" class="px-5 py-2 text-stone-600 hover:text-stone-900 transition">Cars</a>
            <a href="/wijaya_transport/admin.php?module=payments" class="px-5 py-2 text-stone-600 hover:text-stone-900 transition">Payments</a>
            <a href="/wijaya_transport/admin.php?module=auth&action=logout" class="px-5 py-2 text-stone-600 hover:text-stone-900 transition">Logout</a>
        </nav>
      </header>

      <!-- MAIN CONTENT -->
      <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100 w-full">
        <div class="flex items-center justify-between w-full gap-8 mb-5">
            <h1 class="text-3xl font-bold tracking-tight">Daftar Transaksi Booking Masuk</h1>
            <a href="/wijaya_transport/admin.php?module=cars" class="inline-flex items-center justify-center bg-black text-white px-4 py-2 rounded-full font-semibold hover:bg-gray-800 text-sm">Kelola Mobil</a>
        </div>
        <div class="max-w-2xl w-full mb-5">
            <p class="text-sm text-stone-500 leading-7">Kelola status pembayaran dan ketersediaan armada secara cepat dan jelas di satu halaman.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-[#f3eee7] text-stone-700 font-bold border-b border-stone-200">
                        <th class="py-3 px-3">Booking ID</th>
                        <th class="py-3 px-3">Nama Pemesan</th>
                        <th class="py-3 px-3">Nomor WA</th>
                        <th class="py-3 px-3">Mobil</th>
                        <th class="py-3 px-3">Tanggal Sewa</th>
                        <th class="py-3 px-3">Total Harga</th>
                        <th class="py-3 px-3 text-center">Status Pembayaran</th>
                        <th class="py-3 px-3 text-center">Dokumen</th>
                        <th class="py-3 px-3 text-center">Bukti Transfer</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bookings)): ?>
                        <?php foreach ($bookings as $booking): ?>
                            <?php 
                                // Bersihkan string status
                                $st_raw = $booking['status'] ?? $booking['payment_status'] ?? 'pending';
                                $st = strtolower(trim($st_raw));
                                
                                $ktp = $booking['foto_ktp'] ?? $booking['ktp_file'] ?? $booking['dokumen'] ?? null;
                                $bukti = $booking['proof_image'] ?? $booking['payment_proof'] ?? $booking['bukti_transfer'] ?? null;
                                $ktpUrl = $ktp ? '/wijaya_transport/' . ltrim($ktp, '/') : null;
                                $buktiUrl = $bukti ? '/wijaya_transport/' . ltrim($bukti, '/') : null;
                            ?>
                            <tr class="border-b border-stone-100 hover:bg-stone-50/50 transition">
                                <td class="py-4 px-3 font-semibold text-stone-600">#<?= $booking['id'] ?></td>
                                <td class="py-4 px-3 font-semibold text-stone-800"><?= htmlspecialchars($booking['customer_name'] ?? $booking['name'] ?? $booking['user_name'] ?? '-') ?></td>
                                <td class="py-4 px-3 text-stone-600"><?= htmlspecialchars($booking['whatsapp'] ?? $booking['customer_phone'] ?? $booking['phone'] ?? '-') ?></td>
                                <td class="py-4 px-3 font-medium text-stone-700"><?= htmlspecialchars(trim(($booking['car_brand'] ?? $booking['brand'] ?? '') . ' ' . ($booking['car_model'] ?? $booking['model'] ?? ''))) ?></td>
                                <td class="py-4 px-3 text-stone-600 whitespace-nowrap"><?= $booking['tanggal_sewa'] ?? $booking['created_at'] ?? '-' ?></td>
                                <td class="py-4 px-3 font-bold text-stone-800 whitespace-nowrap">Rp <?= number_format($booking['total_harga'] ?? $booking['total_price'] ?? 0, 0, ',', '.') ?></td>
                                
                                <!-- STATUS -->
                                <td class="py-4 px-3 text-center">
                                    <?php if ($st === 'lunas' || $st === 'paid' || $st === 'completed'): ?>
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-semibold rounded-full border border-emerald-200/60 inline-block">Lunas</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-amber-50 text-amber-700 font-semibold rounded-full border border-amber-200/60 inline-block">Pending</span>
                                    <?php endif; ?>
                                </td>

                                <!-- DOKUMEN -->
                                <td class="py-4 px-3 text-center">
                                    <?php if ($ktpUrl): ?>
                                        <a href="<?= htmlspecialchars($ktpUrl) ?>" target="_blank" class="px-2.5 py-1 bg-stone-100 text-stone-700 font-medium rounded-lg inline-block hover:bg-stone-200">📄 Lihat KTP</a>
                                    <?php else: ?>
                                        <span class="text-stone-300">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- BUKTI -->
                                <td class="py-4 px-3 text-center">
                                    <?php if ($buktiUrl): ?>
                                        <a href="<?= htmlspecialchars($buktiUrl) ?>" target="_blank" class="px-2.5 py-1 bg-stone-100 text-stone-700 font-medium rounded-lg inline-block hover:bg-stone-200">🖼️ Lihat Bukti</a>
                                    <?php else: ?>
                                        <span class="text-stone-300">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- AKSI (LOGIKA TERKUNCI MATI) -->
                                <td class="py-4 px-3 text-center align-middle">
                                    <div class="flex items-center justify-center">
                                        <?php if ($st === 'pending'): ?>
                                            <a href="process_payment.php?id=<?= $booking['id'] ?>&action=paid" 
                                               class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl shadow-sm transition whitespace-nowrap inline-block cursor-pointer">
                                                Konfirmasi Pembayaran
                                            </a>
                                        <?php else: ?>
                                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-semibold rounded-full border border-emerald-200/60 inline-flex items-center gap-1">
                                                ✓ Selesai
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
