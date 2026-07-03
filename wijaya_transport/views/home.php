<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Wijaya Transport — Home</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <link rel="stylesheet" href="/wijaya_transport/assets/css/home.css">
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
  </style>
</head>
<body>
  <header class="site-header">
    <div class="nav">
      <div class="navbar-left" style="position: absolute !important; left: 20px !important; top: 50%; transform: translateY(-50%) !important; z-index: 999999 !important; display: block !important;">
        <button id="menuToggle" class="menu-btn" style="cursor: pointer; background: none; border: none; font-size: 16px; font-weight: bold; padding: 0; margin: 0; white-space: nowrap;" aria-label="Open menu">☰ MENU</button>
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
    <section class="hero-viewport" aria-label="Hero">
      <?php
        // choose hero image/video — default to the supplied TEMERARIO image
        $heroImage = '/wijaya_transport/assets/media/temerario.jpg';
        if(file_exists(__DIR__ . '/../assets/media/temerario.jpg')) {
          $heroImage = '/wijaya_transport/assets/media/temerario.jpg';
        } elseif(file_exists(__DIR__ . '/../assets/media/aventuragt.jpg')) {
          $heroImage = '/wijaya_transport/assets/media/aventuragt.jpg';
        }
      ?>
      <div class="hero-bg" id="heroBg" style="background-image:url('<?=htmlspecialchars($heroImage)?>')"></div>
      <div class="hero-overlay"></div>

      <?php if(file_exists(__DIR__ . '/../assets/media/hero.mp4')): ?>
        <video id="heroVideo" class="hero-media" autoplay muted loop playsinline>
          <source src="/wijaya_transport/assets/media/hero.mp4" type="video/mp4">
        </video>
      <?php endif; ?>

      <div class="hero-content">
        <div class="hero-left">
          <div class="brand-label">WIJAYA TRANSPORT</div>
          <h2 class="model-big" id="homepageModel">FENOMENO ROADSTER</h2>
          <div class="cta-row">
            <a class="btn-discover" href="/wijaya_transport/index.php?page=cars">DISCOVER MORE <span class="arrow">→</span></a>
          </div>
        </div>
      </div>

      <div class="controls">
        <div class="progress-lines" id="progressLines"></div>
        <button id="pauseBtn" class="hex-pause" title="Pause">▌▌</button>
      </div>
    </section>

    <section id="cars" class="cars-list container" style="padding:48px 24px">
      <h2 class="section-title">Available Cars</h2>
      <p class="muted">Explore our fleet.</p>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">© Wijaya Transport</div>
  </footer>

  <script>
    const cars = [
      {
        brand: "Lamborghini",
        model: "TEMERARIO",
        slogan: "YOU CAN'T HIDE WHO YOU ARE",
        image: "assets/media/temerario.jpg"
      },
      {
        brand: "Lamborghini",
        model: "AVENTURA GT",
        slogan: "YOU CAN'T HIDE WHO YOU ARE",
        image: "assets/media/aventuragt.jpg"
      }
    ];

    window.__HOME_SLIDES = cars.map((car, idx) => ({
      title: car.model,
      image: '/wijaya_transport/' + car.image,
      position: 'center center',
      slogan: car.slogan,
      index: idx
    }));
  </script>
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
  <script src="/wijaya_transport/assets/js/home.js"></script>
  <script>
    function render(index) {
      if (window.homeSliderGo) {
        window.homeSliderGo(index);
      }
    }
  </script>
</body>
</html>
