<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?=htmlspecialchars($car['brand'].' '.$car['model'])?> — Detail</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <style>
    body{margin:0;background:#06070b;color:#f8fafc;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif}
    .detail-shell{min-height:100vh;padding:110px 24px 80px;position:relative;overflow:hidden;background-color:#090a0f;color:#ffffff}
    .detail-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;filter:blur(30px) brightness(.6) contrast(1.1);transform:scale(1.15);z-index:0}
    .detail-overlay{position:absolute;inset:0;background:radial-gradient(circle at 80% 20%, rgba(15,23,42,0.4) 0%, rgba(5,7,10,0.85) 100%);z-index:1}
    .detail-back{display:inline-flex;align-items:center;gap:10px;color:#cbd5e1;text-decoration:none;font-size:.95rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:32px;position:relative;z-index:2}
    .detail-back svg{width:16px;height:16px;stroke:#cbd5e1}
    .detail-hero{max-width:1240px;margin:0 auto;position:relative;z-index:2}
    .detail-headline{display:grid;grid-template-columns:1fr;gap:40px}
    .detail-content{position:relative;z-index:2;display:grid;grid-template-columns:1.1fr .9fr;gap:48px;align-items:start}
    .viewer-panel{background:rgba(22,25,35,0.75);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.1);border-radius:24px;box-shadow:0 20px 45px rgba(0,0,0,0.35);padding:0;display:flex;justify-content:center;align-items:center;min-height:520px;overflow:hidden;position:relative}
    .viewer-panel img{width:100%;height:100%;object-fit:cover;display:block}
    .info-panel{display:flex;flex-direction:column;gap:28px;justify-content:center}
    .info-meta{font-size:.92rem;letter-spacing:.18em;text-transform:uppercase;color:#f59e0b;margin-bottom:12px}
    .info-title{margin:0;font-size:3.4rem;line-height:.92;letter-spacing:.02em;text-transform:uppercase;color:#ffffff;max-width:10ch;position:relative;z-index:1}
    .info-copy{margin:0;color:#cbd5e1;line-height:1.8;font-size:1rem;max-width:540px}
    .spec-grid{display:grid;grid-template-columns:repeat(2,minmax(140px,1fr));gap:16px}
    .spec-card{background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:24px;display:flex;flex-direction:column;gap:10px;box-shadow:0 18px 32px rgba(0,0,0,.16);backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px)}
    .spec-label{font-size:.82rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.14em}
    .spec-value{font-size:1.15rem;font-weight:700;color:#ffffff}
    .book-row{display:flex;gap:16px;flex-wrap:wrap;align-items:center}
    .btn-cta{display:inline-flex;align-items:center;justify-content:center;padding:18px 30px;border-radius:999px;border:none;color:#fff;font-size:1rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;box-shadow:0 18px 40px rgba(0,0,0,.2);transition:transform .18s ease,background .18s ease,opacity .18s ease}
    .btn-cta.available{background:linear-gradient(135deg, #f59e0b 0%, #d97706 100%);color:#000000}
    .btn-cta.available:hover{transform:translateY(-2px);box-shadow:0 20px 45px rgba(245,158,11,0.35)}
    .btn-cta.unavailable{background:rgba(255,255,255,0.12);color:#e2e8f0;border:1px solid rgba(255,255,255,0.16);box-shadow:none}
    .btn-cta.unavailable:hover{transform:none;cursor:pointer;opacity:.95}
    .book-note{color:#94a3b8;font-size:.95rem;max-width:360px}
    .viewer-overlay{position:absolute;inset:0;border-radius:36px;pointer-events:none;box-shadow:inset 0 0 0 1px rgba(255,255,255,.04)}
    @media(max-width:980px){.detail-content{grid-template-columns:1fr;}.viewer-panel{min-height:420px;}.info-title{font-size:2.8rem;}}
    @media(max-width:680px){.detail-shell{padding:28px 18px 48px;} .viewer-panel{min-height:320px;} .info-title{font-size:2.2rem;} .spec-grid{grid-template-columns:1fr;}}
  </style>
</head>
<body>
  <main class="detail-shell">
    <img src="/wijaya_transport/assets/media/temerario.jpg" alt="Background Blur" class="detail-bg">
    <div class="detail-overlay"></div>
    <?php $statusKey = strtolower(trim($car['status'] ?? 'available')); ?>
  <?php $isAvailable = $statusKey === 'available'; ?>
  <div class="detail-hero">
      <a class="detail-back" href="/wijaya_transport/index.php?page=cars" aria-label="Kembali ke katalog">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        Kembali ke katalog
      </a>
      <div class="detail-headline">
        <div class="detail-content">
          <section class="viewer-panel" aria-label="Gambar detail mobil">
            <?php if($isAvailable): ?>
              <div style="position:absolute;top:24px;right:24px;padding:8px 14px;border-radius:999px;background:rgba(52,211,153,.15);color:#166534;font-weight:700;font-size:.82rem;z-index:3">Tersedia</div>
            <?php else: ?>
              <div style="position:absolute;top:24px;right:24px;padding:8px 14px;border-radius:999px;background:rgba(248,113,113,.17);color:#991b1b;font-weight:700;font-size:.82rem;z-index:3">Dipakai</div>
            <?php endif; ?>
            <?php $viewerImage = !empty($car['image']) ? '/wijaya_transport/' . ltrim($car['image'], '/') : '/wijaya_transport/assets/media/hero-1.svg'; ?>
            <img src="<?=htmlspecialchars($viewerImage)?>" alt="<?=htmlspecialchars($car['brand'].' '.$car['model'])?>">
          </section>

          <section class="info-panel">
            <div>
              <p class="info-meta">Detail Kendaraan</p>
              <h1 class="info-title"><?=htmlspecialchars($car['brand'].' '.$car['model'])?></h1>
              <p class="info-copy">Penawaran premium dengan tampilan bersih dan elegan, dirancang untuk pengalaman sewa mobil yang mewah dan mudah.</p>
            </div>

            <div class="spec-grid">
              <div class="spec-card">
                <span class="spec-label">Tahun</span>
                <span class="spec-value"><?=htmlspecialchars($car['year'] ?? '-')?></span>
              </div>
              <div class="spec-card">
                <span class="spec-label">Plat Nomor</span>
                <span class="spec-value"><?=htmlspecialchars($car['plate_number'] ?? '-')?></span>
              </div>
              <div class="spec-card">
                <span class="spec-label">Harga / hari</span>
                <span class="spec-value">Rp <?=htmlspecialchars(number_format($car['price_per_day'] ?? 0,0,',','.'))?></span>
              </div>
              <div class="spec-card">
                <span class="spec-label">Status</span>
                <span class="spec-value"><?=htmlspecialchars(ucfirst($car['status'] ?? 'available'))?></span>
              </div>
            </div>

            <div class="book-row">
              <a class="btn-cta <?= $isAvailable ? 'available' : 'unavailable' ?>" href="<?= $isAvailable ? '/wijaya_transport/index.php?page=booking&action=new&car_id=' . urlencode($car['id']) : '#' ?>" data-available="<?= $isAvailable ? '1' : '0' ?>" data-car-name="<?=htmlspecialchars($car['brand'].' '.$car['model'])?>">BOOKING NOW</a>
            </div>
          </section>
        </div>
      </div>
    </div>
  </main>

  <script>
    (function(){
      const bookingButton = document.querySelector('.btn-cta[data-available="0"]');
      if(bookingButton){
        bookingButton.addEventListener('click', function(event){
          event.preventDefault();
          const carName = bookingButton.getAttribute('data-car-name') || 'mobil ini';
          alert(`Maaf, ${carName} saat ini tidak tersedia (sedang dipakai). Silakan pilih mobil lain yang tersedia.`);
        });
      }
    })();
  </script>
</body>
</html>
