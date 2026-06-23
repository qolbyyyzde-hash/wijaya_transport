// Cars slider logic (reads window.__CARS provided by server)
(function(){
  const cars = window.__CARS || [];
  // if no cars defined, nothing to do
  if(!cars) return;
  let index = 0;
  // support multiple markup variants: prefer modern ids, fallback to legacy ones
  const modelName = document.getElementById('modelName') || document.getElementById('modelTitle') || document.getElementById('modelName');
  const modelSlogan = document.getElementById('modelSlogan') || document.getElementById('modelSlogan') || document.getElementById('modelSlogan');
  const heroImg = document.getElementById('heroImg') || document.getElementById('showImg') || document.querySelector('.featured-img');
  const exploreBtn = document.getElementById('exploreBtn') || document.getElementById('exploreLink');
  const configBtn = document.getElementById('configBtn') || document.getElementById('configLink');
  function render(i){
    if(!cars.length) return;
    index = (i + cars.length) % cars.length;
    const c = cars[index];
    if(modelName) modelName.textContent = ((c.brand || '') + ' ' + (c.model || '')).toUpperCase();
    if(modelSlogan) modelSlogan.textContent = (c.slogan || 'Driven by performance — designed for luxury.').toUpperCase();
    if(heroImg){
      // ensure transparent PNGs render cleanly and overlap text
      try{
        heroImg.style.background = 'transparent';
        heroImg.style.objectFit = 'contain';
        heroImg.style.zIndex = 10;
        heroImg.style.position = heroImg.style.position || 'absolute';
      }catch(e){}
      const pre = new Image();
      pre.src = c.image;
      pre.onload = function(){
        if(heroImg.tagName && heroImg.tagName.toLowerCase() === 'img'){
          heroImg.style.opacity = '0';
          setTimeout(()=>{ heroImg.src = c.image; heroImg.style.opacity = '1'; }, 160);
        } else {
          // fallback: set background-image
          heroImg.style.backgroundImage = `url('${c.image}')`;
          heroImg.style.backgroundSize = 'contain';
          heroImg.style.backgroundRepeat = 'no-repeat';
          heroImg.style.backgroundPosition = 'center center';
        }
      };
    }
    if(exploreBtn) exploreBtn.href = '/wijaya_transport/index.php?page=car&action=detail&id=' + c.id;
    if(configBtn) configBtn.href = '/wijaya_transport/index.php?page=booking&action=new&car_id=' + c.id;
  }
  function next(){ index = (index + 1) % cars.length; render(index); }
  function prev(){ index = (index - 1 + cars.length) % cars.length; render(index); }
  document.getElementById('nextBtn').addEventListener('click', next);
  document.getElementById('prevBtn').addEventListener('click', prev);
  document.addEventListener('keydown', (e)=>{ if(e.key==='ArrowRight') next(); if(e.key==='ArrowLeft') prev(); });
  document.querySelectorAll('.type-card').forEach(card=>{ card.addEventListener('click', ()=>{ const type = card.getAttribute('data-type'); const mapping = { supercars: ['lamborghini','ferrari','wes'], sedans: ['toyota','honda','mercedes','bmw','audi'], suvs: ['suv','jeep','land','rangerover'], grandtourers: ['grand','gt','tourer'] }; const keywords = mapping[type] || []; let found = cars.findIndex(cc => { const name = (cc.brand + ' ' + cc.model).toLowerCase(); return keywords.some(k=> name.includes(k)); }); if(found === -1) found = 0; index = found; render(index); }); });
  render(index);
})();