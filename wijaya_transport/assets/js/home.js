// Home slider logic extracted from views/home.php
(function(){
  const defaultSlides = [
    {title:'FENOMENO ROADSTER', image:'/wijaya_transport/assets/media/temerario.jpg', position: 'center 70%'},
    {title:'AVENTURA GT', image:'/wijaya_transport/assets/media/aventuragt.jpg', position: 'center center'},
    {title:'AVENTURA GT 2', image:'/wijaya_transport/assets/media/aventuragt_2.jpg', position: 'center center'},
    {title:'CIVIC', image:'/wijaya_transport/assets/media/civic.png', position: 'center center'},
    {title:'SUV PUTIH', image:'/wijaya_transport/assets/media/suv_putih.png', position: 'center center'}
  ];
  const slides = (window.__HOME_SLIDES && Array.isArray(window.__HOME_SLIDES) && window.__HOME_SLIDES.length)
    ? window.__HOME_SLIDES
    : defaultSlides;
  let cur = 0; let playing = true;
  const bg = document.getElementById('heroBg');
  const modelEl = document.getElementById('homepageModel');
  const progressContainer = document.getElementById('progressLines');
  let lines = [];
  function renderProgress(){
    if(!progressContainer) return;
    progressContainer.innerHTML = slides.map((_, idx) => `<div class="prog" data-index="${idx}"></div>`).join('');
    lines = progressContainer.querySelectorAll('.prog');
  }
  function go(i){
    cur = (i + slides.length) % slides.length;
    const s = slides[cur] || {};
    bg.style.backgroundImage = `url('${s.image}')`;
    bg.style.backgroundPosition = s.position || 'center center';
    modelEl.textContent = s.title || '';
    renderProgress();
    lines.forEach((l,idx)=> l.classList.toggle('active', idx===cur));
  }
  window.homeSliderGo = go;
  function next(){ go(cur+1); }
  let timer = setInterval(next, 6000);
  document.getElementById('pauseBtn').addEventListener('click', ()=>{ if(playing){ clearInterval(timer); playing=false; document.getElementById('pauseBtn').textContent='▶'; } else { timer=setInterval(next,6000); playing=true; document.getElementById('pauseBtn').textContent='▌▌'; }});
  if(progressContainer){
    progressContainer.addEventListener('click', (e)=>{
      const prog = e.target.closest ? e.target.closest('.prog') : null;
      const idx = prog ? Number(prog.dataset.index) : -1;
      if(idx >= 0){ go(idx); }
    });
  }
  // initialize
  go(0);
})();