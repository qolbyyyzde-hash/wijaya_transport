<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?=htmlspecialchars($car['brand'].' '.$car['model'])?> — Detail</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <style>
    body{margin:0;background:#fff;color:#111;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif}
    .detail-shell{min-height:100vh;padding:40px 24px 80px;position:relative;overflow-x:hidden}
    .detail-back{display:inline-flex;align-items:center;gap:10px;color:#111;text-decoration:none;font-size:.95rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:32px}
    .detail-back svg{width:16px;height:16px;stroke:#111}
    .detail-hero{max-width:1240px;margin:0 auto;position:relative;z-index:1}
    .detail-headline{position:relative;display:grid;grid-template-columns:1fr;gap:40px}
    .model-mark{position:absolute;top:0;left:0;right:0;font-size:10rem;line-height:.95em;font-weight:800;text-transform:uppercase;letter-spacing:.15em;color:rgba(0,0,0,.04);pointer-events:none;user-select:none;z-index:0}
    .detail-content{position:relative;z-index:2;display:grid;grid-template-columns:1.1fr .9fr;gap:48px;align-items:start}
    .viewer-panel{background:#ffffff;border-radius:24px;box-shadow:0 15px 40px rgba(0,0,0,.04);padding:38px;display:flex;justify-content:center;align-items:center;min-height:520px;overflow:hidden;position:relative}
    .viewer-scene{width:100%;max-width:720px;height:420px;position:relative;perspective:1000px;display:flex;align-items:center;justify-content:center}
    .viewer-watermark{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:8rem;font-weight:800;color:rgba(0,0,0,.03);pointer-events:none;user-select:none;white-space:nowrap;letter-spacing:.2em;z-index:0}
    .viewer-floor-shadow{position:absolute;left:50%;bottom:48px;width:220px;height:78px;background:rgba(0,0,0,.08);border-radius:999px;filter:blur(18px);transform:translateX(-50%);z-index:1}
    .viewer-card{width:100%;height:100%;border-radius:24px;background:#ffffff;display:flex;align-items:center;justify-content:center;overflow:hidden;transform-style:preserve-3d;transition:transform .18s ease-out, box-shadow .18s ease-out;box-shadow:0 12px 36px rgba(0,0,0,.06);will-change:transform;position:relative;z-index:2}
    .viewer-card:hover{box-shadow:0 18px 46px rgba(0,0,0,.1)}
    .viewer-card img{width:100%;height:100%;object-fit:contain;backface-visibility:hidden;pointer-events:none;transform:translateZ(50px);transition:transform .12s ease-out, filter .12s ease-out;filter:drop-shadow(0 12px 24px rgba(0,0,0,0.08))}
    .viewer-card:hover img{transform:translateZ(70px)}
    .viewer-hint{position:absolute;bottom:28px;left:50%;transform:translateX(-50%);color:#666666;font-size:.92rem;letter-spacing:.04em;text-transform:uppercase;z-index:2}
    .info-panel{display:flex;flex-direction:column;gap:28px;justify-content:center}
    .info-meta{font-size:.92rem;letter-spacing:.18em;text-transform:uppercase;color:#777;margin-bottom:12px}
    .info-title{margin:0;font-size:3.4rem;line-height:.92;letter-spacing:.02em;text-transform:uppercase;color:#111;max-width:10ch;position:relative;z-index:1}
    .info-copy{margin:0;color:#444;line-height:1.8;font-size:1rem;max-width:540px}
    .spec-grid{display:grid;grid-template-columns:repeat(2,minmax(140px,1fr));gap:16px}
    .spec-card{background:#f8f5ee;border-radius:20px;padding:24px;display:flex;flex-direction:column;gap:10px;box-shadow:0 18px 32px rgba(0,0,0,.04)}
    .spec-label{font-size:.82rem;color:#666;text-transform:uppercase;letter-spacing:.14em}
    .spec-value{font-size:1.35rem;font-weight:700;color:#111}
    .book-row{display:flex;gap:16px;flex-wrap:wrap;align-items:center}
    .btn-cta{display:inline-flex;align-items:center;justify-content:center;padding:18px 30px;border-radius:999px;border:none;background:#111;color:#fff;font-size:1rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;box-shadow:0 18px 40px rgba(0,0,0,.15);transition:transform .18s ease,background .18s ease}
    .btn-cta:hover{transform:translateY(-2px);background:#000}
    .book-note{color:#666;font-size:.95rem;max-width:360px}
    .viewer-overlay{position:absolute;inset:0;border-radius:36px;pointer-events:none;box-shadow:inset 0 0 0 1px rgba(0,0,0,.03)}
    @media(max-width:980px){.detail-content{grid-template-columns:1fr;}.viewer-panel{min-height:420px;}.model-mark{font-size:7rem;}.info-title{font-size:2.8rem;}}
    @media(max-width:680px){.detail-shell{padding:28px 18px 48px;} .viewer-scene{height:320px;} .model-mark{font-size:5rem;} .info-title{font-size:2.2rem;} .spec-grid{grid-template-columns:1fr;}}
  </style>
</head>
<body>
  <main class="detail-shell">
    <div class="detail-hero">
      <a class="detail-back" href="/wijaya_transport/index.php?page=cars" aria-label="Kembali ke katalog">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        Kembali ke katalog
      </a>
      <div class="detail-headline">
        <div class="model-mark"><?=htmlspecialchars($car['brand'].' '.$car['model'])?></div>
        <div class="detail-content">
          <section class="viewer-panel" aria-label="360 degree car viewer">
            <div class="viewer-scene" id="viewerScene">
              <div class="viewer-watermark"><?=htmlspecialchars($car['brand'])?></div>
              <div class="viewer-floor-shadow"></div>
              <div class="viewer-card" id="viewerCard">
                <?php $viewerImage = !empty($car['image']) ? '/wijaya_transport/' . ltrim($car['image'], '/') : '/wijaya_transport/assets/media/hero-1.svg'; ?>
                <img id="viewerImage" src="<?=htmlspecialchars($viewerImage)?>" alt="<?=htmlspecialchars($car['brand'].' '.$car['model'])?>">
              </div>
              <div class="viewer-hint">Klik dan geser ke kiri / kanan untuk memutar</div>
            </div>
            <div class="viewer-overlay"></div>
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
              <a class="btn-cta" href="/wijaya_transport/index.php?page=booking&action=new&car_id=<?=urlencode($car['id'])?>">BOOKING NOW</a>
              <p class="book-note">Klik tombol untuk melanjutkan ke halaman pemesanan dan amankan mobil ini dengan cepat.</p>
            </div>
          </section>
        </div>
      </div>
    </div>
  </main>

  <script>
    (function(){
      const viewerCard = document.getElementById('viewerCard');
      const viewerScene = document.getElementById('viewerScene');
      const viewerImage = document.getElementById('viewerImage');
      let isDragging = false;
      let startX = 0;
      let startY = 0;
      let currentRotation = 0;
      let currentTilt = 0;

      function getImageSources(){
        const src = document.getElementById('viewerImage').src;
        return [src, src, src, src];
      }

      const frames = getImageSources();
      let frameIndex = 0;

      function updateViewer(angle, tilt = 0){
        currentRotation = angle;
        currentTilt = tilt;
        viewerCard.style.transform = `rotateY(${angle}deg) rotateX(${tilt}deg)`;
        viewerImage.style.transform = `translateZ(70px)`;
        const index = Math.floor((angle % 360 + 360) % 360 / 90) % frames.length;
        if(frames[index]){
          document.getElementById('viewerImage').src = frames[index];
        }
      }

      function pointerDown(event){
        isDragging = true;
        startX = event.clientX || event.touches && event.touches[0].clientX;
        startY = event.clientY || event.touches && event.touches[0].clientY;
        viewerCard.style.transition = 'none';
      }

      function pointerMove(event){
        if(!isDragging) return;
        const x = event.clientX || event.touches && event.touches[0].clientX;
        const y = event.clientY || event.touches && event.touches[0].clientY;
        const deltaX = x - startX;
        const deltaY = y - startY;
        updateViewer(currentRotation + deltaX * 0.35, Math.max(-8, Math.min(8, currentTilt + deltaY * 0.05)));
        startX = x;
        startY = y;
      }

      function pointerUp(){
        if(!isDragging) return;
        isDragging = false;
        viewerCard.style.transition = 'transform .25s ease-out';
      }

      viewerScene.addEventListener('mousedown', pointerDown);
      viewerScene.addEventListener('mousemove', pointerMove);
      window.addEventListener('mouseup', pointerUp);
      viewerScene.addEventListener('touchstart', pointerDown, {passive:true});
      viewerScene.addEventListener('touchmove', pointerMove, {passive:true});
      window.addEventListener('touchend', pointerUp);
    })();
  </script>
</body>
</html>
