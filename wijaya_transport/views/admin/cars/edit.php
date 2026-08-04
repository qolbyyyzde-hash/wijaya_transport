<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Edit Car</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f7f6f0; color: #1c1917; }
  </style>
</head>
<body class="min-h-screen bg-[#f8f6f0]">
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
      <div class="mb-6">
        <h2 class="text-2xl font-bold text-stone-900">Edit Car</h2>
        <p class="text-sm text-stone-500 mt-1">Perbarui data armada mobil yang sudah ada.</p>
      </div>

      <form action="/wijaya_transport/admin.php?module=cars&action=update" method="POST" enctype="multipart/form-data" class="space-y-5">
        <input type="hidden" name="id" value="<?= htmlspecialchars((string)($car['id'] ?? ''), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)($csrf ?? ''), ENT_QUOTES, 'UTF-8') ?>">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div>
            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Brand</label>
            <input type="text" name="brand" value="<?= htmlspecialchars((string)($car['brand'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-stone-50 text-sm focus:outline-none focus:ring-2 focus:ring-stone-900 transition">
          </div>

          <div>
            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Model</label>
            <input type="text" name="model" value="<?= htmlspecialchars((string)($car['model'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-stone-50 text-sm focus:outline-none focus:ring-2 focus:ring-stone-900 transition">
          </div>

          <div>
            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Year</label>
            <input type="text" name="year" value="<?= htmlspecialchars((string)($car['year'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-stone-50 text-sm focus:outline-none focus:ring-2 focus:ring-stone-900 transition">
          </div>

          <div>
            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Plate Number</label>
            <input type="text" name="plate_number" value="<?= htmlspecialchars((string)($car['plate_number'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-stone-50 text-sm focus:outline-none focus:ring-2 focus:ring-stone-900 transition">
          </div>

          <div>
            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Price per Day</label>
            <input type="text" name="price_per_day" value="<?= htmlspecialchars((string)($car['price_per_day'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" required class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-stone-50 text-sm focus:outline-none focus:ring-2 focus:ring-stone-900 transition">
          </div>

          <div>
            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Status</label>
            <select name="status" class="w-full px-4 py-3 rounded-xl border border-stone-200 bg-stone-50 text-sm focus:outline-none focus:ring-2 focus:ring-stone-900 transition">
              <option value="available" <?= ($car['status'] ?? '') === 'available' ? 'selected' : '' ?>>Available</option>
              <option value="unavailable" <?= ($car['status'] ?? '') === 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
            </select>
          </div>
        </div>

        <div class="mt-4">
          <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Car Image (Biarkan kosong jika tidak ingin mengubah)</label>
          <input type="file" name="image" class="w-full p-2 border border-stone-200 rounded-xl bg-stone-50 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-stone-900 file:text-white hover:file:bg-stone-800 transition">
          <?php if (!empty($car['image'])): ?>
            <div class="mt-3">
              <p class="text-xs font-semibold text-stone-500 uppercase tracking-wider mb-2">Current Image</p>
              <img src="/wijaya_transport/<?= htmlspecialchars((string)$car['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Current car image" class="h-28 w-auto rounded-xl border border-stone-200 object-cover">
            </div>
          <?php endif; ?>
        </div>

        <div class="pt-4">
          <button type="submit" name="update" class="w-full bg-stone-900 hover:bg-stone-800 text-white font-bold py-3.5 px-6 rounded-xl text-sm transition shadow-md">
            Update Car Data
          </button>
        </div>
      </form>
    </div>
  </main>
</body>
</html>
