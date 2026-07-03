<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Catalog — Wijaya Transport</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <style>
    .navbar-left { position: relative; }
    .menu-dropdown {
      display: none !important;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #ffffff;
      min-width: 180px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      border-radius: 6px;
      padding: 10px 0;
      margin-top: 10px;
      z-index: 99999;
    }
    .menu-dropdown.show {
      display: flex !important;
      flex-direction: column !important;
    }
    .menu-dropdown a {
      padding: 12px 20px;
      text-decoration: none;
      color: #000000;
      font-size: 14px;
      font-family: sans-serif;
      transition: background 0.2s;
    }
    .menu-dropdown a:hover {
      background-color: #f5f5f5;
    }
    .site-header-local{position:fixed;top:0;left:0;width:100%;display:flex;justify-content:space-between;align-items:center;height:80px;padding:0 60px;box-sizing:border-box;z-index:99999999 !important;background:#ffffff;pointer-events:auto !important}
    .nav-local{display:flex;justify-content:space-between;align-items:center;width:100%;max-width:1200px;margin:0 auto;color:#000;height:100%}
    .nav-left-local,.nav-center-local,.nav-right-local{display:flex;align-items:center;height:100%}
    .nav-left-local{flex:0 0 auto}
    .nav-center-local{flex:1 1 auto;justify-content:center;font-weight:700;letter-spacing:6px;color:#000}
    .menu-btn-local{display:inline-flex;align-items:center;gap:8px;background:transparent;border:none;color:#000;font-weight:700;letter-spacing:2px;font-size:13px;cursor:pointer;margin:0;padding:0;position:relative;z-index:10;pointer-events:auto;transition:color .2s ease}
    .menu-btn-local::after{content:'';position:absolute;left:0;right:0;bottom:-2px;height:2px;background:transparent;transition:background .2s ease}
    .menu-btn-local:hover{color:rgba(0,0,0,0.8)}
    .menu-btn-local:hover::after{background:rgba(0,0,0,0.15)}
    .search-btn-local{background:transparent;border:none;padding:6px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;border-radius:6px;pointer-events:auto}
    .menu-text-local{color:#000}

    body{margin:0;background:#fff;color:#000;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial}
    .catalog{padding:140px 24px 48px;min-height:100vh;background:#fff}
    .catalog-inner{max-width:1400px;margin:0 auto;display:flex;flex-direction:column;gap:22px}
    .page-title{margin:0;font-size:3rem;letter-spacing:0.08em;text-transform:uppercase}
    .page-subtitle{margin:0;color:#555;font-size:1.05rem;max-width:760px;line-height:1.6}
    .catalog-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;margin-top:36px}
    .car-card{background:#f9f8f4;border:1px solid rgba(0,0,0,0.08);border-radius:20px;overflow:hidden;display:flex;flex-direction:column;transition:transform .18s ease,box-shadow .18s ease}
    .car-card:hover{transform:translateY(-4px);box-shadow:0 18px 36px rgba(0,0,0,0.08)}
    .car-image{width:100%;aspect-ratio:16/10;object-fit:cover}
    .car-body{padding:22px 22px 28px;display:flex;flex-direction:column;gap:14px}
    .car-meta{font-size:0.82rem;letter-spacing:0.18em;text-transform:uppercase;color:#666}
    .car-title{margin:0;font-size:1.6rem;letter-spacing:0.02em;text-transform:uppercase}
    .car-slogan{margin:0;color:#444;line-height:1.5}
    .car-info{display:flex;flex-wrap:wrap;gap:12px;font-size:0.95rem;color:#333}
    .car-info span{background:rgba(0,0,0,0.04);padding:8px 12px;border-radius:10px}
    .car-actions{margin-top:auto;display:flex;gap:12px;flex-wrap:wrap}
    .car-link{display:inline-flex;align-items:center;justify-content:center;padding:12px 18px;border-radius:10px;text-decoration:none;font-weight:700;letter-spacing:0.03em}
    .car-link.primary{background:#8B7500;color:#fff}
    .car-link.secondary{background:transparent;color:#000;border:1px solid rgba(0,0,0,0.12)}
    .empty-state{padding:48px;text-align:center;color:#666;font-size:1.2rem;background:#fafafa;border:1px solid rgba(0,0,0,0.06);border-radius:18px}
    @media(max-width:900px){
      .page-title{font-size:2.5rem}
      .catalog{padding-top:120px}
      .car-body{padding:18px}
    }
  </style>
</head>
<body>
  <header class="site-header-local" role="banner">
    <div class="nav-local">
      <div class="navbar-left" style="position: absolute !important; left: 20px !important; top: 50%; transform: translateY(-50%) !important; z-index: 999999 !important; display: block !important;">
        <button id="menuToggle" class="menu-btn menu-btn-local" style="cursor: pointer; background: none; border: none; font-size: 16px; font-weight: bold; padding: 0; margin: 0; white-space: nowrap;" aria-label="Open menu">☰ MENU</button>
        <div id="dropdownMenu" style="display: none !important; position: absolute; top: 100%; left: 0 !important; right: auto !important; margin-top: 10px; background-color: #ffffff; min-width: 160px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); border-radius: 8px; padding: 10px 0; z-index: 999999; flex-direction: column !important; transform: none !important; text-align: left !important;">
          <a href="/wijaya_transport/" style="display: block !important; padding: 12px 20px; color: #000000; text-decoration: none; font-family: sans-serif; font-size: 14px; text-align: left;">Home</a>
          <a href="/wijaya_transport/index.php?page=cars" style="display: block !important; padding: 12px 20px; color: #000000; text-decoration: none; font-family: sans-serif; font-size: 14px; text-align: left;">Catalog</a>
          <a href="/wijaya_transport/index.php?page=booking&action=new" style="display: block !important; padding: 12px 20px; color: #000000; text-decoration: none; font-family: sans-serif; font-size: 14px; text-align: left;">Booking</a>
        </div>
      </div>
      <div class="nav-center-local">WIJAYA TRANSPORT</div>
      <div class="nav-right-local" style="position: absolute !important; right: 20px !important; top: 50%; transform: translateY(-50%) !important; z-index: 999999 !important; display: flex !important; align-items: center;">
        <form action="/wijaya_transport/index.php" method="GET" style="margin: 0; display: flex; align-items: center;">
          <input type="hidden" name="page" value="cars">
          <input type="text" name="search" placeholder="Cari mobil..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" style="padding: 6px 12px; border: 1px solid rgba(0,0,0,0.2); border-radius: 4px; font-size: 14px; background: transparent; color: inherit;">
          <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 16px; margin-left: 5px; color: inherit;">🔍</button>
        </form>
      </div>
  </header>

  <main class="catalog" role="main" aria-label="Car catalog">
    <div class="catalog-inner">
      <h1 class="page-title">Catalog Mobil</h1>
      <p class="page-subtitle">Temukan pilihan armada kami secara jelas dan cepat.</p>
      <div class="catalog-grid">
        <?php if(!empty($cars) && is_array($cars)): ?>
          <?php foreach($cars as $car): ?>
            <?php $image = !empty($car['image']) ? '/wijaya_transport/' . ltrim($car['image'], '/') : '/wijaya_transport/assets/media/hero-1.svg'; ?>
            <article class="car-card">
              <img class="car-image" src="<?=htmlspecialchars($image)?>" alt="<?=htmlspecialchars($car['brand'].' '.$car['model'])?>">
              <div class="car-body">
                <div>
                  <div class="car-meta"><?=htmlspecialchars($car['brand'] ?? '')?></div>
                  <h2 class="car-title"><?=htmlspecialchars($car['model'] ?? '')?></h2>
                </div>
                <p class="car-slogan"><?=htmlspecialchars($car['description'] ?? 'YOU CAN\'T HIDE WHO YOU ARE')?></p>
                <div class="car-info">
                  <span>Year: <?=htmlspecialchars($car['year'] ?? '-')?></span>
                  <span>Plate: <?=htmlspecialchars($car['plate_number'] ?? '-')?></span>
                  <span>Rp <?=htmlspecialchars(number_format($car['price_per_day'] ?? 0,0,',','.'))?> / hari</span>
                </div>
                <div class="car-actions">
                  <a class="car-link primary" href="/wijaya_transport/index.php?page=car&action=detail&id=<?=urlencode($car['id'])?>">Lihat Detail</a>
                  <a class="car-link secondary" href="/wijaya_transport/index.php?page=booking&action=new&car_id=<?=urlencode($car['id'])?>">Booking</a>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="empty-state">Belum ada mobil tersedia saat ini.</div>
        <?php endif; ?>
      </div>
    </div>
  </main>
  <script src="/wijaya_transport/assets/js/main.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      const toggleBtn = document.getElementById('menuToggle');
      const dropdown = document.getElementById('dropdownMenu');

      if (toggleBtn && dropdown) {
          toggleBtn.addEventListener('click', function(e) {
              e.stopPropagation();
              if (dropdown.style.getPropertyValue('display') === 'none' || dropdown.style.display === 'none') {
                  dropdown.style.setProperty('display', 'flex', 'important');
              } else {
                  dropdown.style.setProperty('display', 'none', 'important');
              }
          });

          document.addEventListener('click', function() {
              dropdown.style.setProperty('display', 'none', 'important');
          });
      }
  });
  </script>
</body>
</html>
