(function () {
  function qs(sel, root = document) { return root.querySelector(sel); }
  function qsa(sel, root = document) { return Array.from(root.querySelectorAll(sel)); }

  const root = qs('[data-home-showcase]');
  if (!root || !window.MI_TEMA_HOME || !Array.isArray(window.MI_TEMA_HOME.properties)) return;

  const properties = window.MI_TEMA_HOME.properties;
  let activeIndex = 0;

  // Simula carrusel de "imágenes" por propiedad (wireframe). Puedes conectarlo luego a una galería real.
  // Por ahora: usa la misma imagen repetida 4 veces como placeholders de carrusel.
  const imageSlots = 4;
  let activeImageIndex = 0;

  const elImage = qs('[data-property-image]', root);
  const elTitle = qs('[data-property-title]', root);
  const elLocation = qs('[data-property-location]', root);
  const elPrice = qs('[data-property-price]', root);
  const elBadges = qs('[data-property-badges]', root);
  const elLink = qs('[data-property-link]', root);
  const elLink2 = qs('[data-property-link-secondary]', root);

  const dotsWrap = qs('[data-carousel-dots]', root);
  const featuredStrip = qs('[data-featured-strip]', root);

  const btnPrev = qs('[data-carousel-prev]', root);
  const btnNext = qs('[data-carousel-next]', root);

  function renderDots() {
    dotsWrap.innerHTML = '';
    for (let i = 0; i < imageSlots; i++) {
      const b = document.createElement('button');
      b.type = 'button';
      b.className = 'dot-btn' + (i === activeImageIndex ? ' is-active' : '');
      b.setAttribute('aria-label', 'Imagen ' + (i + 1));
      b.addEventListener('click', function () {
        activeImageIndex = i;
        update();
      });
      dotsWrap.appendChild(b);
    }
  }

  function renderFeaturedStrip() {
    featuredStrip.innerHTML = '';
    // muestra hasta 3 propiedades distintas para navegar rápido
    const items = properties.slice(0, 3);
    items.forEach((p, idx) => {
      const card = document.createElement('div');
      card.className = 'featured-item';
      card.setAttribute('role', 'button');
      card.setAttribute('tabindex', '0');
      card.addEventListener('click', function () {
        activeIndex = idx;
        activeImageIndex = 0;
        update();
      });
      card.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') card.click();
      });

      const img = document.createElement('img');
      img.src = p.image;
      img.alt = p.title;

      const t = document.createElement('div');
      t.className = 'fi-title';
      t.textContent = p.title;

      card.appendChild(img);
      card.appendChild(t);
      featuredStrip.appendChild(card);
    });
  }

  function update() {
    const p = properties[activeIndex] || properties[0];

    // Imagen “principal” (en wireframe)
    // Si luego manejas galería real, aquí seleccionas p.images[activeImageIndex]
    elImage.src = p.image;
    elImage.alt = p.title;

    elTitle.textContent = p.title;
    elLocation.textContent = p.location || '';
    elPrice.textContent = p.price || '';

    elBadges.innerHTML = '';
    (p.badges || []).forEach((txt) => {
      const span = document.createElement('span');
      span.className = 'badge';
      span.textContent = txt;
      elBadges.appendChild(span);
    });

    if (p.permalink) {
      elLink.href = p.permalink;
      elLink2.href = p.permalink;
    }

    renderDots();
  }

  function prevProperty() {
    activeIndex = (activeIndex - 1 + properties.length) % properties.length;
    activeImageIndex = 0;
    update();
  }

  function nextProperty() {
    activeIndex = (activeIndex + 1) % properties.length;
    activeImageIndex = 0;
    update();
  }

  if (btnPrev) btnPrev.addEventListener('click', prevProperty);
  if (btnNext) btnNext.addEventListener('click', nextProperty);

  // Init
  renderFeaturedStrip();
  update();
})();