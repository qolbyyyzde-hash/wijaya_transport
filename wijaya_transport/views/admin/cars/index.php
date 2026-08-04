<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin — Cars</title>
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
    .admin-card, .card { background: #ffffff; border-radius: 24px; padding: 32px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); max-width: 1320px; width: 100%; margin: 0 auto 40px auto; border: 1px solid #f8fafc; }
    .admin-heading { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .admin-heading h1 { margin: 0; font-size: 2rem; color: #111111 !important; }
    .admin-subtitle { margin: 8px 0 0; color: #111111 !important; max-width: 760px; line-height: 1.6; }
    .admin-link, .btn-dark, .btn-add { display: inline-flex; align-items: center; justify-content: center; padding: 12px 20px; border-radius: 999px; background: #111111; color: #ffffff !important; border: 1px solid #111111; text-decoration: none; font-weight: 700; }
    .admin-link:hover, .btn-dark:hover, .btn-add:hover { background: #222222; }
    .btn-small { display: inline-flex; align-items: center; justify-content: center; padding: 8px 14px; border-radius: 12px; font-size: 0.92rem; text-decoration: none; }
    .btn-edit { background: #f5f5f5; color: #111111 !important; border: 1px solid #ddd; }
    .btn-edit:hover { background: #e9e9e9; }
    .btn-delete { background: #fee2e2; color: #b91c1c !important; border: 1px solid #f5c2c2; }
    .btn-delete:hover { background: #fcd5d5; }
    .btn-add { background: #111111; color: #ffffff !important; border: none; padding: 10px 20px; font-size: 0.85rem; letter-spacing: .02em; }
    .admin-link:hover, .btn-dark:hover { background: #222222; }
    .btn-small { display: inline-flex; align-items: center; justify-content: center; padding: 8px 14px; border-radius: 12px; font-size: 0.92rem; text-decoration: none; }
    .btn-edit { background: #f5f5f5; color: #111111 !important; border: 1px solid #ddd; }
    .btn-edit:hover { background: #e9e9e9; }
    .btn-delete { background: #fee2e2; color: #b91c1c !important; border: 1px solid #f5c2c2; }
    .btn-delete:hover { background: #fcd5d5; }
    .card table { width: 100%; table-layout: auto; border-collapse: collapse; }
    .card table thead th { background: #f1efe9; padding: 12px; font-weight: 700; text-align: left; color: #111111 !important; }
    .card table tbody td { padding: 12px; border-bottom: 1px solid #eee; color: #111111 !important; }
    .card table tbody tr:last-child td { border-bottom: none; }
    img.car-thumb { width: 120px !important; max-width: 120px !important; height: auto !important; object-fit: contain; border-radius: 8px; }
    .actions { display: inline-flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .table-scroll { width: 100%; overflow-x: auto; }
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
          <a href="/wijaya_transport/admin.php?module=cars" class="px-5 py-2 bg-stone-900 text-white rounded-full transition" style="color: #ffffff !important;">Cars</a>
          <a href="/wijaya_transport/admin.php?module=payments" class="px-5 py-2 text-stone-600 hover:text-stone-900 transition">Payments</a>
          <a href="/wijaya_transport/admin.php?module=auth&action=logout" class="px-5 py-2 text-stone-600 hover:text-stone-900 transition">Logout</a>
        </nav>
      </header>
      <div class="bg-white rounded-3xl p-8 shadow-sm border border-stone-100 w-full">
        <div class="admin-heading">
          <div>
            <h1>Manajemen Mobil</h1>
            <p class="admin-subtitle">Tambah, edit, atau hapus armada dengan antarmuka yang bersih dan mudah dibaca.</p>
          </div>
          <div>
            <a href="/wijaya_transport/admin.php?module=cars&action=new" class="btn-add">TAMBAH MOBIL BARU</a>
          </div>
        </div>

        <div class="table-scroll">
          <table class="w-full text-left divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="w-[5%] text-left px-4 py-3 text-sm font-semibold text-stone-900 border-b border-gray-200">ID</th>
                <th class="w-[15%] text-left px-4 py-3 text-sm font-semibold text-stone-900 border-b border-gray-200">Brand</th>
                <th class="w-[15%] text-left px-4 py-3 text-sm font-semibold text-stone-900 border-b border-gray-200">Model</th>
                <th class="w-[10%] text-left px-4 py-3 text-sm font-semibold text-stone-900 border-b border-gray-200">Tahun</th>
                <th class="w-[12%] text-left px-4 py-3 text-sm font-semibold text-stone-900 border-b border-gray-200">Harga / Hari</th>
                <th class="w-[13%] text-center px-4 py-3 text-sm font-semibold text-stone-900 border-b border-gray-200">Status Mobil</th>
                <th class="w-[15%] text-center px-4 py-3 text-sm font-semibold text-stone-900 border-b border-gray-200">Gambar</th>
                <th class="w-[25%] text-center px-4 py-3 text-sm font-semibold text-stone-900 border-b border-gray-200">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php foreach($cars as $c): ?>
              <tr>
                <td class="text-left px-4 py-4 text-sm text-stone-700"><?=htmlspecialchars($c['id'])?></td>
                <td class="text-left px-4 py-4 text-sm text-stone-700"><?=htmlspecialchars($c['brand'])?></td>
                <td class="text-left px-4 py-4 text-sm text-stone-700"><?=htmlspecialchars($c['model'])?></td>
                <td class="text-left px-4 py-4 text-sm text-stone-700"><?=htmlspecialchars($c['year'])?></td>
                <td class="text-left px-4 py-4 text-sm text-stone-700">Rp <?=number_format($c['price_per_day'],0,',','.')?></td>
                <td class="text-center px-4 py-4 text-sm font-semibold <?= strtolower(trim($c['status'] ?? 'available')) === 'available' ? 'text-emerald-700' : 'text-rose-700' ?>">
                  <?= htmlspecialchars(strtolower(trim($c['status'] ?? 'available')) === 'available' ? 'Tersedia' : 'Disewa') ?>
                </td>
                <td class="text-center px-4 py-4">
                  <?php if(!empty($c['image'])): ?>
                    <img src="/wijaya_transport/<?=htmlspecialchars($c['image'])?>" alt="<?=htmlspecialchars($c['brand'].' '.$c['model'])?>" class="car-thumb" style="width:80px; height:48px; object-fit: contain; display:block; margin:0 auto;">
                  <?php else: ?>
                    —
                  <?php endif; ?>
                </td>
                <td class="text-center px-4 py-4">
                  <div class="flex flex-wrap items-center justify-center gap-2">
                    <a href="/wijaya_transport/admin.php?module=cars&action=edit&id=<?=$c['id']?>" class="px-3 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-semibold rounded-lg transition">Edit</a>
                    <form method="post" action="/wijaya_transport/admin.php?module=cars&action=toggle_status" style="display:inline-flex; margin:0;">
                      <input type="hidden" name="id" value="<?=htmlspecialchars($c['id'])?>">
                      <input type="hidden" name="status" value="<?= strtolower(trim($c['status'] ?? 'available')) === 'available' ? 'unavailable' : 'available' ?>">
                      <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
                      <button type="submit" class="px-3 py-1.5 <?= strtolower(trim($c['status'] ?? 'available')) === 'available' ? 'bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' ?> text-xs font-semibold rounded-lg transition">
                        <?= strtolower(trim($c['status'] ?? 'available')) === 'available' ? 'Set Disewa' : 'Set Tersedia' ?>
                      </button>
                    </form>
                    <form method="post" action="/wijaya_transport/admin.php?module=cars&action=delete" style="display:inline-block; margin:0;" onsubmit="return confirm('Yakin hapus?')">
                      <input type="hidden" name="id" value="<?=htmlspecialchars($c['id'])?>">
                      <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
                      <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold rounded-lg transition">Hapus</button>
                    </form>
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
