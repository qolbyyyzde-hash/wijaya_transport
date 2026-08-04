<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Form</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
</head>
<body>
  <div class="page-shell">
    <div class="card booking-card w-full max-w-6xl mx-auto p-8">
      <h2>Booking Form</h2>
      <p class="muted">Pilih mobil dan isi detail booking Anda.</p>
      <form action="/wijaya_transport/controllers/booking_controller.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?=htmlspecialchars($csrf)?>">
        <input type="hidden" id="car_price" name="car_price" value="0">
        <input type="hidden" id="input_total_price" name="total_price" value="0">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="space-y-6">
            <div class="form-field">
              <label>Mobil</label>
              <select id="car_id" name="car_id" required>
                <option value="" data-price="0">-- pilih mobil --</option>
                <?php foreach($cars as $c): ?>
                  <?php $statusKey = strtolower(trim($c['status'] ?? 'available')); $available = $statusKey === 'available'; ?>
                  <option value="<?=htmlspecialchars($c['id'])?>" data-price="<?=htmlspecialchars($c['price_per_day'])?>" <?=isset($selected) && $selected == $c['id'] ? 'selected' : ''?> <?=!$available ? 'disabled' : ''?>><?=htmlspecialchars($c['brand'].' '.$c['model'].' (Rp '.number_format($c['price_per_day'],0,',','.').')'.(!$available?' - Dipakai':'') )?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-field">
              <label>Nama Pemesan</label>
              <input name="name" required>
            </div>

            <div class="form-field">
              <label>Nomor WhatsApp</label>
              <input name="phone" required placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-field">
              <label class="dark-form-label">Layanan Sewa</label>
              <select name="driver_option" class="dark-form-select" id="driver_option">
                <option value="Lepas Kunci" data-fee="0">Lepas Kunci (Tanpa Sopir - Rp 0)</option>
                <option value="Dengan Sopir" data-fee="150000">Dengan Sopir (+ Rp 150.000 / hari)</option>
              </select>
            </div>

            <div class="form-field">
              <label class="dark-form-label">Metode Pengambilan</label>
              <select id="pickup_option" name="pickup_option" class="dark-form-select">
                <option value="Ambil di Garasi" data-fee="0">Ambil Sendiri di Garasi (Gratis)</option>
                <option value="Diantar Area Dalam Kota" data-fee="50000">Diantar Area Dalam Kota (+ Rp 50.000)</option>
                <option value="Diantar Area Luar Kota / Bandara" data-fee="100000">Diantar Area Luar Kota / Bandara (+ Rp 100.000)</option>
              </select>
            </div>

            <div class="flex gap-3">
              <div class="form-field" style="flex:1;">
                <label>Tanggal Mulai</label>
                <input id="tanggal_mulai" type="date" name="start_date" required>
              </div>
              <div class="form-field" style="flex:1;">
                <label>Tanggal Selesai</label>
                <input id="tanggal_selesai" type="date" name="end_date" required>
              </div>
            </div>
          </div>

          <div class="space-y-6">
            <div class="form-field">
              <label>Upload Foto KTP (Wajib)</label>
              <input type="file" name="ktp_file" accept="image/*" required>
            </div>

            <div class="form-field">
              <label>Metode Pembayaran</label>
              <select name="payment_method" required>
                <option value="">-- pilih metode --</option>
                <option value="Transfer BCA">Transfer Bank BCA</option>
                <option value="Transfer Mandiri">Transfer Bank Mandiri</option>
                <option value="QRIS">QRIS</option>
              </select>
            </div>

            <div class="mt-6 p-6 bg-amber-500/10 border border-amber-500/30 rounded-2xl text-left">
              <div class="flex items-center gap-2 mb-3">
                <span class="text-amber-400 font-bold text-sm">📌 Syarat & Ketentuan Jaminan</span>
              </div>
              <ul class="text-sm text-stone-300 space-y-3 list-disc list-inside leading-relaxed">
                <li><strong>Upload Foto:</strong> Foto KTP diunggah sebagai verifikasi awal data pemesan.</li>
                <li><strong>Jaminan Fisik:</strong> KTP Asli wajib diserahkan & ditahan di garasi saat pengambilan unit.</li>
                <li><strong>Pengembalian:</strong> Dokumen jaminan dikembalikan setelah unit kembali dalam kondisi baik.</li>
              </ul>
            </div>

            <div class="form-actions" style="justify-content:flex-end; margin-top: 24px;">
              <a class="btn-ghost-light" href="/wijaya_transport/index.php?page=cars">Batal</a>
              <button class="btn-confirm" type="submit">Confirm Booking</button>
            </div>
          </div>
        </div>
      </form>
      <script>
        const driverOption = document.getElementById('driver_option');
        const pickupOption = document.getElementById('pickup_option');
        const carSelect = document.getElementById('car_id');
        const carPriceInput = document.getElementById('car_price');
        const totalPriceInput = document.getElementById('input_total_price');
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalSelesai = document.getElementById('tanggal_selesai');
        const textDurasi = document.getElementById('text_durasi');
        const textSubtotal = document.getElementById('text_subtotal');
        const textSopir = document.getElementById('text_sopir');
        const textPengantaran = document.getElementById('text_pengantaran');
        const textTotal = document.getElementById('text_total');

        function formatRupiah(value) {
          return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);
        }

        function updateHarga() {
          const hargaMobil = parseFloat(carPriceInput.value) || 0;
          const biayaSopirPerHari = parseFloat(driverOption.selectedOptions[0]?.dataset.fee || 0) || 0;
          const biayaPengantaran = parseFloat(pickupOption.selectedOptions[0]?.dataset.fee || 0) || 0;

          let durasi = 1;
          const tglMulai = new Date(tanggalMulai.value);
          const tglSelesai = new Date(tanggalSelesai.value);
          if (tanggalMulai.value && tanggalSelesai.value && tglSelesai >= tglMulai) {
            const diffTime = Math.abs(tglSelesai - tglMulai);
            durasi = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) || 1;
          }

          const subtotalMobil = hargaMobil * durasi;
          const totalSopir = biayaSopirPerHari * durasi;
          const grandTotal = subtotalMobil + totalSopir + biayaPengantaran;

          textDurasi.innerText = durasi;
          textSubtotal.innerText = formatRupiah(subtotalMobil);
          textSopir.innerText = formatRupiah(totalSopir);
          textPengantaran.innerText = formatRupiah(biayaPengantaran);
          textTotal.innerText = formatRupiah(grandTotal);
          totalPriceInput.value = grandTotal;
        }

        function updateCarPrice() {
          const selected = carSelect.selectedOptions[0];
          carPriceInput.value = selected ? selected.dataset.price || 0 : 0;
          updateHarga();
        }

        [driverOption, pickupOption, carSelect, tanggalMulai, tanggalSelesai].forEach(el => {
          if (el) {
            el.addEventListener('change', () => {
              if (el === carSelect) updateCarPrice();
              else updateHarga();
            });
          }
        });

        updateCarPrice();
      </script>
    </div>
  </div>
</body>
</html>
