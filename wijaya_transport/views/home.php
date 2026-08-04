<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Wijaya Transport — Home</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <link rel="stylesheet" href="/wijaya_transport/assets/css/home.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <style>
  .navbar-left {
      position: relative;
  }
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
  /* Hero custom - modern premium styling */
  .hero-viewport{position:relative;min-height:75vh;display:flex;align-items:center}
  .relative{position:relative}
  .absolute{position:absolute}
  .inset-0{top:0;right:0;bottom:0;left:0}
  .w-full{width:100%}
  .h-full{height:100%}
  .h-screen{height:100vh}
  .overflow-hidden{overflow:hidden}
  .bg-black{background-color:#000}
  .bg-transparent{background-color:transparent}
  .z-0{z-index:0}
  .z-10{z-index:10}
  .z-30{z-index:30}
  .pointer-events-none{pointer-events:none}
  .pointer-events-auto{pointer-events:auto}
  .bg-gradient-to-r{background-image:linear-gradient(to right, rgba(0,0,0,0.9), rgba(0,0,0,0.5), transparent)}
  .container{width:100%;max-width:1200px;margin-left:auto;margin-right:auto}
  .mx-auto{margin-left:auto;margin-right:auto}
  .px-6{padding-left:1.5rem;padding-right:1.5rem}
  .md\:px-12{padding-left:3rem;padding-right:3rem}
  .max-w-2xl{max-width:42rem}
  .text-white{color:#fff}
  .text-gray-200{color:#e5e7eb}
  .text-amber-500{color:#f59e0b}
  .text-black{color:#000}
  .font-semibold{font-weight:600}
  .font-bold{font-weight:700}
  .font-medium{font-weight:500}
  .tracking-wider{letter-spacing:.08em}
  .uppercase{text-transform:uppercase}
  .mb-2{margin-bottom:0.5rem}
  .mb-4{margin-bottom:1rem}
  .mb-6{margin-bottom:1.5rem}
  .text-3xl{font-size:1.875rem}
  .text-sm{font-size:.875rem}
  .md\:text-5xl{font-size:3rem}
  .md\:text-base{font-size:1rem}
  .leading-tight{line-height:1.2}
  .leading-relaxed{line-height:1.6}
  .flex{display:flex}
  .items-center{align-items:center}
  .flex-wrap{flex-wrap:wrap}
  .gap-4{gap:1rem}
  .inline-block{display:inline-block}
  .rounded-full{border-radius:9999px}
  .transition{transition:all .2s ease}
  .shadow-lg{box-shadow:0 12px 24px rgba(0,0,0,.2)}
  .backdrop-blur-md{backdrop-filter:blur(8px)}
  .bg-white\/10{background-color:rgba(255,255,255,.1)}
  .bg-white\/20{background-color:rgba(255,255,255,.2)}
  .border{border:1px solid}
  .border-white\/30{border-color:rgba(255,255,255,.3)}
  .py-3{padding-top:.75rem;padding-bottom:.75rem}
  .px-6{padding-left:1.5rem;padding-right:1.5rem}
  .swiper,.swiper-wrapper,.swiper-slide{height:100%}
  .swiper-slide{width:100%}
  .heroSwiper img{width:100%;height:100%;object-fit:cover;display:block}
  .flex{display:flex}
  .items-center{align-items:center}
  .container{width:100%;max-width:1200px;margin-left:auto;margin-right:auto}
  .px-6{padding-left:1.5rem;padding-right:1.5rem}
  .md\:px-12{padding-left:3rem;padding-right:3rem}
  .max-w-2xl{max-width:42rem}
  .text-white{color:#fff}
  .text-gray-200{color:#e5e7eb}
  .text-gray-300{color:#d1d5db}
  .text-amber-500{color:#f59e0b}
  .text-black{color:#000}
  .font-semibold{font-weight:600}
  .font-bold{font-weight:700}
  .font-medium{font-weight:500}
  .tracking-wider{letter-spacing:.08em}
  .uppercase{text-transform:uppercase}
  .mb-2{margin-bottom:0.5rem}
  .mb-4{margin-bottom:1rem}
  .mb-6{margin-bottom:1.5rem}
  .text-3xl{font-size:1.875rem}
  .text-sm{font-size:.875rem}
  .md\:text-5xl{font-size:3rem}
  .md\:text-base{font-size:1rem}
  .leading-tight{line-height:1.2}
  .leading-relaxed{line-height:1.6}
  .flex-wrap{flex-wrap:wrap}
  .gap-4{gap:1rem}
  .inline-block{display:inline-block}
  .rounded-full{border-radius:9999px}
  .transition{transition:all .2s ease}
  .shadow-lg{box-shadow:0 12px 24px rgba(0,0,0,.2)}
  .backdrop-blur-md{backdrop-filter:blur(8px)}
  .bg-black\/40{background-color:rgba(0,0,0,.4)}
  .bg-white\/10{background-color:rgba(255,255,255,.1)}
  .bg-white\/20{background-color:rgba(255,255,255,.2)}
  .border{border:1px solid}
  .border-white\/30{border-color:rgba(255,255,255,.3)}
  .px-6{padding-left:1.5rem;padding-right:1.5rem}
  .py-3{padding-top:.75rem;padding-bottom:.75rem}
  .swiper-slide{position:absolute;inset:0;opacity:0;pointer-events:none;transition:opacity .6s ease}
  .swiper-slide.active{opacity:1;pointer-events:auto}
  .swiper-slide img{width:100%;height:100%;object-fit:cover;display:block}
  .hero-text-overlay{background:rgba(0,0,0,.35)}
  .hero-cta-primary{display:inline-block;padding:12px 24px;border-radius:999px;background:#f59e0b;color:#000;font-weight:700;text-decoration:none;box-shadow:0 16px 30px rgba(0,0,0,.25)}
  .hero-cta-primary:hover{background:#fbbf24}
  .hero-cta-secondary{display:inline-block;padding:12px 24px;border-radius:999px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.3);color:#fff;font-weight:500;text-decoration:none;backdrop-filter:blur(8px)}
  .hero-cta-secondary:hover{background:rgba(255,255,255,.2)}
  </style>
</head>
<body>
  <header class="site-header">
    <div class="nav">
      <div class="navbar-left" style="position: absolute !important; left: 0px !important; top: 50%; transform: translateY(-50%) !important; z-index: 999999 !important; padding-left: 10px;">
        <button id="menuToggle" class="menu-btn" style="cursor: pointer; background: none; border: none; font-size: 16px; font-weight: bold; padding: 0; margin: 0; white-space: nowrap; color: #1e293b !important;" aria-label="Open menu">☰ MENU</button>
        <div id="dropdownMenu" style="display: none !important; position: absolute; top: 100%; left: 0 !important; right: auto !important; margin-top: 10px; background-color: #ffffff; min-width: 160px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); border-radius: 8px; padding: 10px 0; z-index: 999999; flex-direction: column !important; transform: none !important; text-align: left !important;">
          <a href="/wijaya_transport/" style="display: block !important; padding: 12px 20px; color: #000000; text-decoration: none; font-family: sans-serif; font-size: 14px; text-align: left;">Home</a>
          <a href="/wijaya_transport/index.php?page=cars" style="display: block !important; padding: 12px 20px; color: #000000; text-decoration: none; font-family: sans-serif; font-size: 14px; text-align: left;">Catalog</a>
          <a href="/wijaya_transport/index.php?page=booking&action=new" style="display: block !important; padding: 12px 20px; color: #000000; text-decoration: none; font-family: sans-serif; font-size: 14px; text-align: left;">Booking</a>
        </div>
      </div>

      <div class="nav-center">
        <div class="brand">WIJAYA TRANSPORT</div>
      </div>

      <div class="nav-right" style="position: absolute !important; right: 20px !important; top: 50%; transform: translateY(-50%) !important; z-index: 999999 !important; display: flex !important; align-items: center;">
        <form action="/wijaya_transport/index.php" method="GET" style="margin: 0; display: flex; align-items: center;">
          <input type="hidden" name="page" value="cars">
          <input type="text" name="search" placeholder="Cari mobil..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" style="padding: 6px 12px; border: 1px solid rgba(255,255,255,0.3); border-radius: 4px; font-size: 14px; background: transparent; color: inherit;">
          <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 16px; margin-left: 5px; color: inherit;">🔍</button>
        </form>
      </div>
  </header>

  <main>
    <?php
      require_once __DIR__ . '/../models/Car.php';

      $heroCars = [];
      if (isset($cars) && is_array($cars) && !empty($cars)) {
        $heroCars = $cars;
      } elseif (isset($pdo) && $pdo instanceof PDO) {
        $carModel = new Car($pdo);
        $heroCars = $carModel->all();
      }
    ?>
    <section class="relative w-full h-screen overflow-hidden bg-slate-950" aria-label="Hero">
      <div class="absolute inset-0 z-0 w-full h-full">
        <?php if (!empty($heroCars) && isset($heroCars[0]['image'])): ?>
          <img src="uploads/<?= htmlspecialchars($heroCars[0]['image']); ?>" class="w-full h-full object-cover opacity-60" alt="Hero Background" onError="this.onerror=null;this.src='https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1920&q=80';">
        <?php else: ?>
          <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover opacity-60" alt="Hero Background">
        <?php endif; ?>
      </div>

      <div class="absolute inset-0 z-10 flex items-center bg-gradient-to-r from-black/80 via-black/40 to-transparent">
        <div class="container mx-auto px-6 md:px-12">
          <div class="max-w-2xl text-white">
            <p class="text-amber-500 font-semibold tracking-wider uppercase mb-2">
              WIJAYA TRANSPORT LOMBOK
            </p>
            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4">
              Jelajahi Pesona Lombok Tanpa Batas
            </h1>
            <p class="text-gray-200 text-sm md:text-base mb-6 leading-relaxed">
              Sewa mobil murah, aman, dan nyaman di Mataram. Melayani lepas kunci, driver profesional, serta layanan antar-jemput area Mataram &amp; Bandara Lombok!
            </p>
            <div style="display: flex; gap: 16px; flex-wrap: wrap; margin-top: 24px; position: relative; z-index: 20;">
              <a href="cars.php" style="background-color: #f59e0b; color: #000000; font-weight: bold; padding: 12px 28px; border-radius: 9999px; text-decoration: none; display: inline-block; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);">
                Sewa Sekarang →
              </a>

              <a href="cars.php" style="background-color: rgba(255, 255, 255, 0.15); color: #ffffff; font-weight: 500; padding: 12px 28px; border-radius: 9999px; border: 1px solid rgba(255, 255, 255, 0.4); text-decoration: none; display: inline-block; cursor: pointer; backdrop-filter: blur(8px);">
                Lihat Armada Mobil
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer style="background-color: #09090b; color: #a1a1aa; padding-top: 48px; padding-bottom: 24px; border-top: 1px solid #27272a; font-family: sans-serif;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 32px;">
      <div>
        <h3 style="color: #ffffff; font-size: 20px; font-weight: 700; margin-bottom: 12px; letter-spacing: 1px;">WIJAYA TRANSPORT</h3>
        <p style="font-size: 14px; line-height: 1.6; margin-bottom: 16px;">
          Penyedia layanan sewa mobil terpercaya di Mataram &amp; Lombok. Melayani lepas kunci, driver profesional, serta antar-jemput area bandara.
        </p>
      </div>

      <div>
        <h4 style="color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 16px;">Navigasi</h4>
        <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; line-height: 2;">
          <li><a href="#" style="color: #a1a1aa; text-decoration: none;">Home</a></li>
          <li><a href="cars.php" style="color: #a1a1aa; text-decoration: none;">Pilihan Armada</a></li>
          <li><a href="#services" style="color: #a1a1aa; text-decoration: none;">Layanan Kami</a></li>
        </ul>
      </div>

      <div>
        <h4 style="color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 16px;">Kontak Kami</h4>
        <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px; line-height: 2;">
          <li>📍 Mataram, Nusa Tenggara Barat</li>
          <li>📞 WhatsApp / Telp: +62 812-3456-7890</li>
          <li>✉️ Email: info@wijayatransport.com</li>
        </ul>
      </div>
    </div>

    <div style="max-width: 1200px; margin: 32px auto 0 auto; padding-top: 24px; border-top: 1px solid #18181b; text-align: center; font-size: 13px; color: #71717a;">
      &copy; <?= date('Y'); ?> Wijaya Transport Lombok. All Rights Reserved.
    </div>
  </footer>

  <script>
    window.__HOME_SLIDES = <?= json_encode($heroSlides, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
  </script>
  <script src="/wijaya_transport/assets/js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      if (window.Swiper) {
        new Swiper('.heroSwiper', {
          loop: true,
          autoplay: {
            delay: 3500,
            disableOnInteraction: false,
          },
          effect: 'fade',
          fadeEffect: {
            crossFade: true
          }
        });
      }
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function(){
      function smoothToCars(e){
        e.preventDefault();
        var el = document.getElementById('cars');
        if(el){ el.scrollIntoView({behavior:'smooth', block:'start'}); }
      }
      var cta = document.getElementById('ctaDiscover');
      var cta2 = document.getElementById('ctaFleet');
      if(cta) cta.addEventListener('click', smoothToCars);
      if(cta2) cta2.addEventListener('click', smoothToCars);
    });
  </script>
  <script>
    // Defensive: ensure H1 remains static regardless of slider scripts
    document.addEventListener('DOMContentLoaded', function(){
      var h = document.getElementById('homepageModel');
      if(h) h.textContent = 'Jelajahi Pesona Lombok Tanpa Batas';
    });
  </script>
</body>
</html>
