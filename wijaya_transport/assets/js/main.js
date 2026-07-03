// Minimal JS placeholder
document.addEventListener('DOMContentLoaded',function(){
  // hero video play/pause toggle
  try{
    var hex = document.getElementById('hexToggle');
    var video = document.getElementById('heroVideo');
    if(hex && video){
      hex.addEventListener('click', function(){
        if(video.paused){ video.play(); hex.querySelector('.hex-icon').innerText = '▌▌'; }
        else { video.pause(); hex.querySelector('.hex-icon').innerText = '►'; }
      });
    }
  } catch(e){}
  // Smooth scroll for in-page anchors (href starting with '#')
  try{
    document.querySelectorAll('a[href^="#"]').forEach(function(a){
      a.addEventListener('click', function(ev){
        var href = a.getAttribute('href');
        if(!href || href === '#') return;
        // only handle true in-page anchors (no full path)
        if(href.indexOf('#') === 0){
          var target = document.querySelector(href);
          if(target){ ev.preventDefault(); target.scrollIntoView({behavior:'smooth',block:'start'}); }
        }
      });
    });
  } catch(e){}

  // Menu toggle logic for header menu button and sidebar dropdown
  try{
    const btn = document.querySelector('.menu-btn') || document.querySelector('.menu-btn-local') || document.getElementById('menuToggle');
    const menuContainer = document.querySelector('.menu-dropdown') || document.querySelector('.sidebar-menu') || document.querySelector('.nav-menu');

    if (btn && menuContainer) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        menuContainer.classList.toggle('active');
        menuContainer.classList.toggle('show');
        console.log('Tombol MENU berhasil merespons klik!');
      });

      document.addEventListener('click', function() {
        menuContainer.classList.remove('active');
        menuContainer.classList.remove('show');
      });
    }
  } catch(e){}
});
