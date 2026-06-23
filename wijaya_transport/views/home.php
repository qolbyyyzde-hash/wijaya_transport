<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Wijaya Transport — Home</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <link rel="stylesheet" href="/wijaya_transport/assets/css/home.css">
</head>
<body>
  <header class="site-header">
    <div class="nav">
      <div class="nav-left">
        <button class="menu-btn" aria-label="Open menu">
          <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0.75 2.5H17.25" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/><path d="M0.75 7H17.25" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/><path d="M0.75 11.5H17.25" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg>
          <span class="menu-text">MENU</span>
        </button>
      </div>

      <div class="nav-center">
        <div class="brand">WIJAYA TRANSPORT</div>
      </div>

      <div class="nav-right">
        <button class="search-btn" aria-label="Search">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><circle cx="11" cy="11" r="6" stroke="#fff" stroke-width="1.6"/><path d="M20 20L16.65 16.65" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg>
        </button>
      </div>
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
        <div class="progress-lines" id="progressLines">
          <div class="prog active"></div>
          <div class="prog"></div>
          <div class="prog"></div>
        </div>
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

  <script src="/wijaya_transport/assets/js/home.js"></script>
  <script>
    // Provide slides data explicitly so slider uses the real JPG assets
    window.__HOME_SLIDES = [
      {title: 'FENOMENO ROADSTER', image: '/wijaya_transport/assets/media/temerario.jpg', position: 'center 70%'},
      {title: 'TEMERARIO', image: '/wijaya_transport/assets/media/temerario.jpg', position: 'center 70%'},
      {title: 'AVENTURA GT', image: '/wijaya_transport/assets/media/aventuragt.jpg', position: 'center center'}
    ];
  </script>
