<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Showcase — Wijaya Transport</title>
  <link rel="stylesheet" href="/wijaya_transport/assets/css/style.css">
  <style>
    /* page-local header styles to match white showcase */
    .site-header-local{position:absolute;top:0;left:0;width:100%;z-index:100;background:transparent;padding:25px 50px;box-sizing:border-box}
    .nav-local{display:flex;justify-content:space-between;align-items:center;max-width:1200px;margin:0 auto;color:#000}
    .nav-left-local,.nav-center-local,.nav-right-local{display:flex;align-items:center}
    .nav-center-local{flex:1;justify-content:center;font-weight:700;letter-spacing:6px;color:#000}
    .menu-btn-local{display:inline-flex;align-items:center;gap:10px;background:transparent;border:none;color:#000;font-weight:700;letter-spacing:2px;font-size:13px;cursor:pointer;padding:6px}
    .search-btn-local{background:transparent;border:none;padding:6px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer;border-radius:6px}
    .menu-text-local{color:#000}

    /* Showcase (Lamborghini-style) - centered stacked layout */
    :root{--olive:#8B7500;--muted:#444;--bg:#ffffff;--text:#000}
    html,body{height:100%;margin:0;background-color:var(--bg);color:var(--text);font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial}
    .showcase{min-height:85vh;display:flex;flex-direction:column;align-items:center;justify-content:center;position:relative;text-align:center;width:100%;overflow:hidden;padding:24px;box-sizing:border-box;padding-top:100px}
    .showcase-inner{width:100%;max-width:1400px;display:flex;flex-direction:column;align-items:center;gap:12px}

    /* Background giant title (stacked typography) */
    .brand-model{position:relative;z-index:1;font-size:10vw;font-weight:900;letter-spacing:-3px;line-height:0.95;color:#000;text-transform:uppercase;margin:0;padding:0;margin-bottom:0;padding-bottom:0}
    .slogan{position:relative;z-index:1;font-size:4vw;color:#444;margin-top:-2% !important;text-transform:uppercase}

    /* Floating image layer that overlaps the giant text */
    .img-card{position:relative;z-index:10}
    .featured-img{max-width:75vw;height:auto;display:block;position:relative;z-index:10;transition:all 0.3s ease;margin-top:-12% !important;filter:drop-shadow(0 20px 30px rgba(0,0,0,0.15));background:transparent;object-fit:contain}

    /* navigation arrows (left/right) */
    .nav-arrow{position:absolute;top:50%;transform:translateY(-50%);width:64px;height:64px;display:flex;align-items:center;justify-content:center;border:1px solid rgba(0,0,0,0.12);border-radius:50%;background:transparent;color:var(--text);cursor:pointer;z-index:20}
    .nav-arrow.left{left:40px}
    .nav-arrow.right{right:40px}
    .nav-arrow:hover{background:rgba(0,0,0,0.04)}

    /* bottom action bar - moved under image */
    .action-bar{display:flex;gap:30px;justify-content:center;align-items:center;margin-top:50px;width:100%;z-index:20;position:relative}
    .btn-primary{background:#8B7500;color:#fff;padding:12px 35px;border:none;border-radius:6px;text-transform:uppercase;font-weight:700;text-decoration:none}
    .btn-secondary{background:transparent;color:var(--text);text-transform:uppercase;font-weight:700;border:none;padding:8px;display:inline-flex;align-items:center;gap:8px}

    @media(max-width:900px){.brand-model{font-size:14vw}.slogan{font-size:6vw}.nav-arrow{width:48px;height:48px}}
  </style>
</head>
<body>

  <header class="site-header-local" role="banner">
    <div class="nav-local">
      <div class="nav-left-local">
        <button class="menu-btn-local" aria-label="Open menu">
          <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0.75 2.5H17.25" stroke="#000" stroke-width="1.6" stroke-linecap="round"/><path d="M0.75 7H17.25" stroke="#000" stroke-width="1.6" stroke-linecap="round"/><path d="M0.75 11.5H17.25" stroke="#000" stroke-width="1.6" stroke-linecap="round"/></svg>
          <span class="menu-text-local">MENU</span>
        </button>
      </div>
      <div class="nav-center-local">WIJAYA TRANSPORT</div>
      <div class="nav-right-local">
        <button class="search-btn-local" aria-label="Search">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><circle cx="11" cy="11" r="6" stroke="#000" stroke-width="1.6"/><path d="M20 20L16.65 16.65" stroke="#000" stroke-width="1.6" stroke-linecap="round"/></svg>
        </button>
      </div>
    </div>
  </header>

  <main class="showcase" role="main" aria-label="Car showcase">
    <div class="showcase-inner">
      <h1 id="modelTitle" class="brand-model">MODEL</h1>
      <div id="modelSlogan" class="slogan">Slogan atau deskripsi singkat mobil.</div>

      <div class="img-card">
        <?php
          $firstImage = '/wijaya_transport/assets/media/hero-1.svg';
          if(isset($cars) && is_array($cars) && count($cars) > 0 && !empty($cars[0]['image'])){
            $firstImage = '/wijaya_transport/' . ltrim($cars[0]['image'],'/');
          }
        ?>
        <img id="showImg" class="featured-img" src="<?=htmlspecialchars($firstImage)?>" alt="Car image">
      </div>

      <div class="action-bar">
        <a id="exploreLink" class="btn-primary" href="#">EXPLORE THE MODEL →</a>
        <a id="configLink" class="btn-secondary" href="#">START CONFIGURATION</a>
        <a id="enquireLink" class="btn-secondary" href="#">ENQUIRE</a>
      </div>
    </div>
  </main>

  <!-- side nav arrows -->
  <button id="prevArrow" class="nav-arrow left" aria-label="Previous">◄</button>
  <button id="nextArrow" class="nav-arrow right" aria-label="Next">►</button>

  <!-- Inject cars data and script -->
  <script>
    window.__CARS = <?= json_encode(array_map(function($c){
        return [
            'id' => (int)$c['id'],
            'brand' => $c['brand'] ?? '',
            'model' => $c['model'] ?? '',
            'image' => isset($c['image']) && $c['image'] !== '' ? '/wijaya_transport/' . $c['image'] : '/wijaya_transport/assets/media/hero-1.svg',
            'slogan' => isset($c['description']) ? $c['description'] : 'YOU CAN\'T HIDE WHO YOU ARE'
        ];
    }, $cars), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) ?>;

    // Add a local Lamborghini Huracan entry (uses transparent PNG)
    try{
      window.__CARS.push({
        id: 0,
        brand: 'Lamborghini',
        model: 'Huracan',
        image: '/wijaya_transport/assets/media/huracan.png',
        slogan: 'THE HURACAN'
      });
    }catch(e){ /* ignore if window.__CARS not defined */ }

    (function(){
      const cars = window.__CARS || [];
      let idx = 0;

      const titleEl = document.getElementById('modelTitle');
      const sloganEl = document.getElementById('modelSlogan');
      const imgEl = document.getElementById('showImg');
      const exploreLink = document.getElementById('exploreLink');
      const configLink = document.getElementById('configLink');
      const enquireLink = document.getElementById('enquireLink');
      const prevBtn = document.getElementById('prevArrow');
      const nextBtn = document.getElementById('nextArrow');

      function render(i){
        if(!cars.length) return;
        idx = (i + cars.length) % cars.length;
        const c = cars[idx];
        // update big stacked text (ke belakang)
        if(titleEl){ titleEl.style.zIndex = 1; titleEl.textContent = (c.model || '').toUpperCase(); }
        if(sloganEl){ sloganEl.style.zIndex = 1; sloganEl.textContent = (c.slogan || '').toUpperCase(); }

        // update image with smooth swap and ensure it floats in front of text
        if(imgEl){
          try{
            imgEl.style.zIndex = 10;
            imgEl.style.position = 'relative';
            imgEl.style.maxWidth = '75vw';
            imgEl.style.height = 'auto';
            imgEl.style.transition = 'all 0.3s ease';
            imgEl.style.marginTop = '-12%';
            imgEl.style.objectFit = 'contain';
            imgEl.style.background = 'transparent';
          }catch(e){}
          const pre = new Image(); pre.src = c.image;
          pre.onload = function(){
            if(imgEl.tagName && imgEl.tagName.toLowerCase() === 'img'){
              imgEl.style.opacity = '0';
              setTimeout(()=>{ imgEl.src = c.image; imgEl.style.opacity = '1'; }, 160);
            } else {
              imgEl.style.backgroundImage = `url('${c.image}')`;
            }
          };
        }
        // update links
        exploreLink.href = '/wijaya_transport/index.php?page=booking&car_id=' + c.id;
        configLink.href = '/wijaya_transport/index.php?page=car&action=detail&id=' + c.id;
        enquireLink.href = '/wijaya_transport/index.php?page=car&action=contact&id=' + c.id;
      }

      function nextSlide(){ render(idx + 1); }
      function prevSlide(){ render(idx - 1); }

      nextBtn.addEventListener('click', nextSlide);
      prevBtn.addEventListener('click', prevSlide);
      document.addEventListener('keydown', (e)=>{ if(e.key === 'ArrowRight') nextSlide(); if(e.key === 'ArrowLeft') prevSlide(); });

      // init
      render(0);
    })();
  </script>

</body>
</html>
