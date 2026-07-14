(function() {
  'use strict';

  const carouselContainer = document.querySelector('#single-property-carousel');
  if (!carouselContainer) return;

  const slides = Array.from(carouselContainer.querySelectorAll('[data-carousel-slide]'));
  const dots = Array.from(carouselContainer.querySelectorAll('[data-carousel-dot]'));
  const prevBtn = carouselContainer.querySelector('[data-carousel-prev]');
  const nextBtn = carouselContainer.querySelector('[data-carousel-next]');
  const blurBg = carouselContainer.querySelector('.carousel-blur-bg');

  if (slides.length === 0) return;

  let currentIndex = 0;

  // Hide navigation buttons if only one slide
  if (slides.length === 1) {
    if (prevBtn) prevBtn.style.display = 'none';
    if (nextBtn) nextBtn.style.display = 'none';
  }

  function showSlide(index) {
    // Ensure index is within bounds with circular navigation
    currentIndex = (index + slides.length) % slides.length;

    // Hide all slides
    slides.forEach(slide => slide.classList.remove('is-active'));
    dots.forEach(dot => dot.classList.remove('is-active'));

    // Show current slide and dot
    slides[currentIndex].classList.add('is-active');
    if (dots[currentIndex]) {
      dots[currentIndex].classList.add('is-active');
      dots[currentIndex].setAttribute('aria-current', 'true');
      dots.forEach((dot, idx) => {
        if (idx !== currentIndex) {
          dot.setAttribute('aria-current', 'false');
        }
      });
    }

    // Update blur background image if available
    if (blurBg && singleCarouselData && singleCarouselData.images && singleCarouselData.images[currentIndex]) {
      const smallImageUrl = singleCarouselData.images[currentIndex].url_small;
      if (smallImageUrl) {
        blurBg.style.setProperty('--image-url', `url('${smallImageUrl}')`);
      }
    }
  }

  // Navigation event listeners
  if (prevBtn) {
    prevBtn.addEventListener('click', () => showSlide(currentIndex - 1));
  }
  if (nextBtn) {
    nextBtn.addEventListener('click', () => showSlide(currentIndex + 1));
  }

  // Dot navigation
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => showSlide(index));
  });

  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') showSlide(currentIndex - 1);
    if (e.key === 'ArrowRight') showSlide(currentIndex + 1);
  });

  // Initialize first slide
  showSlide(0);
})();

// === PROPERTY TABS ===
(function() {
  'use strict';

  var tabContainer = document.querySelector('.property-tabs');
  if (!tabContainer) return;

  var tabs = Array.from(tabContainer.querySelectorAll('[data-tab]'));
  var panels = document.querySelectorAll('.property-tab-panel');
  var indicator = tabContainer.querySelector('.property-tab__indicator');

  function activateTab(tab) {
    var targetId = 'tab-' + tab.dataset.tab;

    tabs.forEach(function(t) {
      t.classList.remove('is-active');
      t.setAttribute('aria-selected', 'false');
    });
    panels.forEach(function(p) {
      p.classList.remove('is-active');
      p.hidden = true;
    });

    tab.classList.add('is-active');
    tab.setAttribute('aria-selected', 'true');
    var panel = document.getElementById(targetId);
    if (panel) {
      panel.hidden = false;
      panel.classList.add('is-active');
    }

    moveIndicator(tab);

    if (tab.dataset.tab === 'ubicacion') {
      initPropertyMap();
    }
  }

  function moveIndicator(tab) {
    if (!indicator) return;
    indicator.style.left = tab.offsetLeft + 'px';
    indicator.style.width = tab.offsetWidth + 'px';
  }

  tabs.forEach(function(tab) {
    tab.addEventListener('click', function() { activateTab(tab); });
  });

  tabContainer.addEventListener('keydown', function(e) {
    var index = tabs.indexOf(document.activeElement);
    if (index < 0) return;
    if (e.key === 'ArrowRight') {
      var next = tabs[(index + 1) % tabs.length];
      next.focus();
      activateTab(next);
    } else if (e.key === 'ArrowLeft') {
      var prev = tabs[(index - 1 + tabs.length) % tabs.length];
      prev.focus();
      activateTab(prev);
    }
  });

  moveIndicator(tabs[0]);

  // === LEAFLET MAP (lazy) ===
  var mapInitialized = false;

  function initPropertyMap() {
    if (mapInitialized) return;
    var mapEl = document.getElementById('property-map');
    if (!mapEl || typeof L === 'undefined') return;

    var lat = parseFloat(mapEl.dataset.lat);
    var lng = parseFloat(mapEl.dataset.lng);
    if (!isFinite(lat) || !isFinite(lng)) {
      mapEl.innerHTML = '<p style="padding:2rem;text-align:center;color:#9e9e9e;">Ubicación no disponible</p>';
      return;
    }

    var map = L.map(mapEl).setView([lat, lng], 15);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
      attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors © <a href="https://carto.com/attributions">CARTO</a>',
      subdomains: 'abcd',
      maxZoom: 19,
    }).addTo(map);
    L.marker([lat, lng]).addTo(map);
    mapInitialized = true;
  }
})();
