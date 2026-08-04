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
      background-color: #141416;
      min-width: 180px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.25);
      border-radius: 8px;
      padding: 10px 0;
      margin-top: 10px;
      z-index: 99999;
      border: 1px solid #27272a;
    }
    .menu-dropdown.show {
      display: flex !important;
      flex-direction: column !important;
    }
    .menu-dropdown a {
      padding: 12px 20px;
      text-decoration: none;
      color: #ffffff;
      font-size: 14px;
      font-family: sans-serif;
      transition: background 0.2s;
    }
    .menu-dropdown a:hover {
      background-color: #1f1f23;
    }
    .site-header-local{position:fixed;top:0;left:0;width:100%;display:flex;justify-content:space-between;align-items:center;height:80px;padding:0 60px;box-sizing:border-box;z-index:99999999 !important;background:rgba(10,10,12,.82);backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,0.08);pointer-events:auto !important}
    .nav-local{display:flex;justify-content:space-between;align-items:center;width:100%;max-width:1200px;margin:0 auto;color:#f4f4f5;height:100%}
    .nav-left-local,.nav-center-local,.nav-right-local{display:flex;align-items:center;height:100%}
    .nav-left-local{flex:0 0 auto}
    .nav-center-local{flex:1 1 auto;justify-content:center;font-weight:700;letter-spacing:6px;color:#ffffff}
    .menu-btn-local{display:inline-flex;align-items:center;gap:8px;background:transparent;border:none;color:#f4f4f5;font-weight:700;letter-spacing:2px;font-size:13px;cursor:pointer;margin:0;padding:0;position:relative;z-index:10;pointer-events:auto;transition:color .2s ease}
    .menu-btn-local::after{content:'';position:absolute;left:0;right:0;bottom:-2px;height:2px;background:transparent;transition:background .2s ease}
    .menu-btn-local:hover{color:#f59e0b}
    .menu-btn-local:hover::after{background:rgba(245,158,11,0.25)}
    .search-btn-local{background:transparent;border:none;padding:6px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;border-radius:6px;pointer-events:auto}
    .menu-text-local{color:#f4f4f5}

    body{margin:0;background:radial-gradient(circle at 50% 0%, #27272a 0%, #0f0f11 100%);color:#f4f4f5;font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif}
    .catalog{padding:130px 24px 60px;min-height:100vh;background:radial-gradient(circle at 50% 0%, #27272a 0%, #0f0f11 100%)}
    .catalog-inner{max-width:1280px;margin:0 auto;display:flex;flex-direction:column;gap:24px}
    .page-header{margin-bottom:40px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.1);padding-bottom:24px}
    .page-title{margin:0 0 6px 0;font-size:32px;font-weight:800;letter-spacing:0.5px;color:#ffffff;text-transform:uppercase}
    .page-subtitle{margin:0;color:#a1a1aa;font-size:14px}
    .catalog-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px}
    .car-card{position:relative;background:rgba(28, 28, 35, 0.75);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.12);border-radius:20px;padding:22px;display:flex;flex-direction:column;transition:all .3s ease;box-shadow:0 15px 30px rgba(0,0,0,0.5)}
    .car-card:hover{transform:translateY(-6px);border-color:rgba(245,158,11,0.5);box-shadow:0 20px 40px rgba(0,0,0,0.7)}
    .car-image-wrap{height:170px;display:flex;align-items:center;justify-content:center;margin-top:15px;margin-bottom:15px;position:relative}
    .car-image{max-width:100%;max-height:100%;object-fit:contain;filter:drop-shadow(0 15px 12px rgba(0,0,0,0.75))}
    .car-body{display:flex;flex-direction:column;gap:10px}
    .availability-badge{position:absolute;top:18px;right:18px;padding:4px 12px;border-radius:999px;font-size:10px;font-weight:800;letter-spacing:0.5px;text-transform:uppercase;z-index:10}
    .availability-badge.available{background:rgba(16, 185, 129, 0.15);color:#34d399;border:1px solid rgba(16,185,129,0.4)}
    .availability-badge.unavailable{background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.4)}
    .car-title{font-size:22px;font-weight:800;color:#ffffff;margin:0 0 12px 0;letter-spacing:-0.3px}
    .car-specs{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:20px}
    .car-specs span{background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);color:#d4d4d8;padding:4px 10px;border-radius:8px;font-size:11px;font-weight:500}
    .car-price-row{display:flex;align-items:center;justify-content:space-between;border-top:1px solid rgba(255,255,255,0.08);padding-top:14px}
    .car-price{display:flex;flex-direction:column;gap:2px}
    .car-price .amount{font-size:20px;font-weight:800;color:#ffffff}
    .car-price .unit{font-size:12px;color:#a1a1aa;font-weight:400}
    .car-actions{display:flex;gap:10px}
    .car-link{flex:1;text-align:center;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.2);color:#ffffff;font-weight:600;padding:10px;border-radius:12px;text-decoration:none;font-size:13px;transition:0.2s}
    .car-link.secondary{background:linear-gradient(135deg, #fbbf24 0%, #d97706 100%);color:#000000;font-weight:800;box-shadow:0 4px 18px rgba(245,158,11,0.35)}
    .car-link:hover{transform:translateY(-1px)}
    .car-meta{font-size:11px;color:#f59e0b;text-transform:uppercase;letter-spacing:1.5px;font-weight:800;margin-bottom:2px}
    .car-slogan{display:none}
    .empty-state{padding:48px;text-align:center;color:#a1a1aa;font-size:1.05rem;background:rgba(28, 28, 35, 0.75);border:1px solid rgba(255,255,255,0.12);border-radius:20px}
    @media(max-width:900px){
      .page-title{font-size:28px}
      .catalog{padding-top:120px}
      .site-header-local{padding:0 24px}
    }
  </style>
</head>
<body>
  <header class="site-header-local" role="banner">
    <div class="nav-local">
      <div class="navbar-left" style="position: absolute !important; left: 0px !important; top: 50%; transform: translateY(-50%) !important; z-index: 999999 !important; padding-left: 10px;">
        <button id="menuToggle" class="menu-btn menu-btn-local" style="cursor: pointer; background: none; border: none; font-size: 16px; font-weight: bold; padding: 0; margin: 0; white-space: nowrap; color: #1e293b !important;" aria-label="Open menu">☰ MENU</button>
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

  <?php
    $heroBackgroundImage = '/wijaya_transport/assets/media/temerario.jpg';
  ?>
  <main role="main" aria-label="Car catalog" style="position: relative; min-height: 100vh; overflow: hidden; background-color: #090a0f; color: #ffffff; font-family: system-ui, -apple-system, sans-serif;">
    <img src="<?= $heroBackgroundImage ?>" alt="Background Blur" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; filter: blur(30px) brightness(0.6) contrast(1.1); transform: scale(1.15); z-index: 0;" />
    <div style="position: absolute; inset: 0; background: radial-gradient(circle at 80% 20%, rgba(15,23,42,0.4) 0%, rgba(5,7,10,0.85) 100%); z-index: 1;"></div>
    <div style="position: relative; z-index: 2; padding-top: 110px; padding-bottom: 60px; padding-left: 28px; padding-right: 28px;">
      <div style="max-width: 1280px; margin: 0 auto;">
        <div style="margin-bottom: 20px;">
        <h1 style="font-size: 28px; font-weight: 800; color: #ffffff; letter-spacing: 0.8px; margin-bottom: 8px; text-transform: uppercase;">PILIHAN ARMADA MOBIL</h1>
        <p style="color: #94a3b8; font-size: 13.5px; margin: 0;">Temukan kendaraan terbaik yang nyaman dan siap menemani perjalanan Anda di Lombok.</p>
      </div>

      <div style="display: flex; align-items: center; text-align: center; margin-bottom: 36px; opacity: 0.35;">
        <div style="flex: 1; border-bottom: 1px solid #64748b;"></div>
        <span style="padding: 0 16px; color: #94a3b8; font-size: 11px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">Wijaya Transport</span>
        <div style="flex: 1; border-bottom: 1px solid #64748b;"></div>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 22px;">
        <?php if(!empty($cars) && is_array($cars)): ?>
          <?php foreach($cars as $car): ?>
            <?php $image = !empty($car['image']) ? '/wijaya_transport/' . ltrim($car['image'], '/') : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=900&q=80'; ?>
            <?php $isAvailable = !isset($car['status']) || !in_array(strtolower($car['status']), ['unavailable','dipesan','tidak tersedia']); ?>
            <?php $badgeText = $isAvailable ? 'TERSEDIA' : 'TIDAK TERSEDIA'; ?>
            <?php $badgeStyle = $isAvailable ? 'background: rgba(34, 197, 94, 0.12); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3);' : 'background: rgba(248, 113, 113, 0.14); color: #f87171; border: 1px solid rgba(248, 113, 113, 0.28);'; ?>
            <?php $brand = htmlspecialchars($car['brand'] ?? 'Mobil'); ?>
            <?php $model = htmlspecialchars($car['model'] ?? 'Unit Mobil'); ?>
            <?php $year = htmlspecialchars($car['year'] ?? '-'); ?>
            <?php $plate = htmlspecialchars($car['plate_number'] ?? '-'); ?>
            <?php $price = htmlspecialchars(number_format($car['price_per_day'] ?? 0,0,',','.')); ?>
            <div style="background: rgba(22, 25, 35, 0.75); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.09); border-radius: 18px; padding: 20px; position: relative; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);" onmouseover="this.style.borderColor='rgba(255, 255, 255, 0.25)'; this.style.transform='translateY(-5px)';" onmouseout="this.style.borderColor='rgba(255, 255, 255, 0.09)'; this.style.transform='translateY(0)';">
              <span style="position: absolute; top: 16px; right: 16px; <?= $badgeStyle ?> padding: 3px 10px; border-radius: 9999px; font-size: 9.5px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">
                <?= htmlspecialchars($badgeText) ?>
              </span>

              <div style="height: 155px; display: flex; align-items: center; justify-content: center; margin-top: 15px; margin-bottom: 15px;">
                <img src="<?= htmlspecialchars($image) ?>" alt="<?= $brand . ' ' . $model ?>" style="max-width: 100%; max-height: 100%; object-fit: contain; filter: drop-shadow(0 15px 12px rgba(0,0,0,0.85));">
              </div>

              <div style="font-size: 10px; color: #d97706; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 800; margin-bottom: 2px;"><?= $brand ?></div>
              <h2 style="font-size: 20px; font-weight: 800; color: #ffffff; margin: 0 0 10px 0; letter-spacing: -0.2px;"><?= $model ?></h2>

              <div style="display: flex; gap: 6px; margin-bottom: 18px; flex-wrap: wrap;">
                <span style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08); color: #cbd5e1; padding: 3px 8px; border-radius: 6px; font-size: 10.5px;">Year: <?= $year ?></span>
                <span style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.08); color: #cbd5e1; padding: 3px 8px; border-radius: 6px; font-size: 10.5px;">Plate: <?= $plate ?></span>
              </div>

              <div style="margin-bottom: 16px;">
                <div style="font-size: 18px; font-weight: 800; color: #ffffff;">
                  Rp <?= $price ?> <span style="font-size: 11px; color: #64748b; font-weight: normal;">/ hari</span>
                </div>
              </div>

              <div style="display: flex; gap: 8px;">
                <a href="/wijaya_transport/index.php?page=car&action=detail&id=<?= urlencode($car['id']) ?>" style="flex: 1; text-align: center; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.15); color: #ffffff; font-weight: 600; padding: 8px; border-radius: 10px; text-decoration: none; font-size: 12px;">Lihat Detail</a>
                <?php if($isAvailable): ?>
                  <a href="/wijaya_transport/index.php?page=booking&action=new&car_id=<?= urlencode($car['id']) ?>" style="flex: 1; text-align: center; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #000000; font-weight: 800; padding: 8px; border-radius: 10px; text-decoration: none; font-size: 12px; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);">Booking →</a>
                <?php else: ?>
                  <a href="#" aria-disabled="true" style="flex: 1; text-align: center; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); color: #64748b; font-weight: 700; padding: 8px; border-radius: 10px; text-decoration: none; font-size: 12px;">Booking</a>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div style="background: rgba(22, 25, 35, 0.75); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.09); border-radius: 18px; padding: 24px; color: #cbd5e1;">Belum ada mobil tersedia saat ini.</div>
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
  <script src="/wijaya_transport/assets/js/main.js"></script>
</body>
</html>
