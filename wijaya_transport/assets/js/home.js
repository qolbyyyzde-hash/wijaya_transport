// Home slider logic for the hero section.
(function(){
  const defaultSlides = [
    {image:'/wijaya_transport/assets/media/temerario.jpg', position: 'center 70%'},
    {image:'/wijaya_transport/assets/media/aventuragt.jpg', position: 'center center'},
    {image:'/wijaya_transport/assets/media/aventuragt_2.jpg', position: 'center center'},
    {image:'/wijaya_transport/assets/media/civic.png', position: 'center center'},
    {image:'/wijaya_transport/assets/media/suv_putih.png', position: 'center center'}
  ];

  const slides = (window.__HOME_SLIDES && Array.isArray(window.__HOME_SLIDES) && window.__HOME_SLIDES.length)
    ? window.__HOME_SLIDES
    : defaultSlides;

  const slider = document.querySelector('.mySwiper');
  const slideEls = slider ? Array.from(slider.querySelectorAll('.swiper-slide')) : [];
  let cur = 0;
  let playing = true;
  let timer = null;

  function renderProgress(){
    const progressContainer = document.getElementById('progressLines');
    if (!progressContainer) return;

    progressContainer.innerHTML = slides.map((_, idx) => `<div class="prog" data-index="${idx}"></div>`).join('');
    const lines = progressContainer.querySelectorAll('.prog');
    lines.forEach((line, idx) => line.classList.toggle('active', idx === cur));
  }

  function go(i){
    cur = (i + slides.length) % slides.length;

    slideEls.forEach((slide, idx) => {
      slide.classList.toggle('active', idx === cur);
    });

    const bg = document.getElementById('heroBg');
    if (bg && slides[cur]) {
      bg.style.backgroundImage = `url('${slides[cur].image}')`;
      bg.style.backgroundPosition = slides[cur].position || 'center center';
    }

    renderProgress();
  }

  window.homeSliderGo = go;

  function next(){ go(cur + 1); }

  const pauseBtn = document.getElementById('pauseBtn');
  if (pauseBtn) {
    pauseBtn.addEventListener('click', () => {
      if (playing) {
        clearInterval(timer);
        playing = false;
        pauseBtn.textContent = '▶';
      } else {
        timer = setInterval(next, 6000);
        playing = true;
        pauseBtn.textContent = '▌▌';
      }
    });
  }

  const progressContainer = document.getElementById('progressLines');
  if (progressContainer) {
    progressContainer.addEventListener('click', (e) => {
      const prog = e.target.closest ? e.target.closest('.prog') : null;
      const idx = prog ? Number(prog.dataset.index) : -1;
      if (idx >= 0) {
        go(idx);
      }
    });
  }

  if (slideEls.length) {
    go(0);
    timer = setInterval(next, 6000);
  } else {
    go(0);
  }
})();