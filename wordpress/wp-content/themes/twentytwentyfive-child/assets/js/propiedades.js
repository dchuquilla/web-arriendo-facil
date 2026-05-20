(function () {
  'use strict';

  var POLL_INTERVAL = 30000;
  var apiUrl = (window.afPropiedades && window.afPropiedades.apiUrl) || '/wp-json/af/v1/accommodations/search';
  var currentFilters = (window.afPropiedades && window.afPropiedades.filters) || {};
  var knownIds = [];
  var pollTimer = null;
  var notificationEl = null;

  function init() {
    var cards = document.querySelectorAll('.properties-grid .property-card');
    cards.forEach(function (card) {
      var href = card.getAttribute('href') || '';
      var match = href.match(/\/([^/]+)\/?$/);
      if (match) knownIds.push(match[1]);
    });

    if (!cards.length) {
      var grid = document.querySelector('.properties-grid');
      if (grid && grid.querySelector('.no-properties')) {
        knownIds = [];
      }
    }

    startPolling();

    document.addEventListener('visibilitychange', function () {
      if (document.hidden) {
        stopPolling();
      } else {
        startPolling();
      }
    });
  }

  function startPolling() {
    if (pollTimer) return;
    pollTimer = setInterval(checkForUpdates, POLL_INTERVAL);
  }

  function stopPolling() {
    if (pollTimer) {
      clearInterval(pollTimer);
      pollTimer = null;
    }
  }

  function checkForUpdates() {
    var body = {
      sort: currentFilters.sort || 'newest',
      per_page: 50,
      page: 1,
    };

    if (currentFilters.location) body.location = currentFilters.location;
    if (currentFilters.price_min) body.price_min = parseFloat(currentFilters.price_min);
    if (currentFilters.price_max) body.price_max = parseFloat(currentFilters.price_max);
    if (currentFilters.property_type) body.property_type = currentFilters.property_type;

    fetch(apiUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body),
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data.success || !data.results) return;

        var newIds = data.results.map(function (r) { return r.id; });
        var hasNew = newIds.some(function (id) {
          return knownIds.indexOf(String(id)) === -1 && knownIds.indexOf(id) === -1;
        });

        if (hasNew) {
          showNotification(data.results);
        }
      })
      .catch(function () {});
  }

  function showNotification(results) {
    if (notificationEl) return;

    var grid = document.querySelector('.properties-grid');
    if (!grid) return;

    notificationEl = document.createElement('div');
    notificationEl.className = 'af-realtime-notification';
    notificationEl.innerHTML =
      '<span>Nuevas propiedades disponibles</span>' +
      '<button type="button" class="af-realtime-btn">Actualizar</button>';

    grid.parentNode.insertBefore(notificationEl, grid);

    requestAnimationFrame(function () {
      notificationEl.classList.add('is-visible');
    });

    notificationEl.querySelector('.af-realtime-btn').addEventListener('click', function () {
      updateGrid(results);
    });
  }

  function updateGrid(results) {
    var grid = document.querySelector('.properties-grid');
    if (!grid) return;

    if (notificationEl) {
      notificationEl.remove();
      notificationEl = null;
    }

    grid.innerHTML = '';
    knownIds = [];

    results.forEach(function (item) {
      var card = createCard(item);
      card.classList.add('af-fade-in');
      grid.appendChild(card);

      var slug = item.url.replace(/\/$/, '').split('/').pop();
      knownIds.push(slug);
    });
  }

  function createCard(item) {
    var a = document.createElement('a');
    a.href = item.url;
    a.className = 'property-card';
    a.setAttribute('data-animate', '');

    var imgSrc = item.image_url || (window.afPropiedades && window.afPropiedades.placeholder) || '';
    var location = item.location || 'Ubicación no especificada';
    var price = item.price > 0 ? '$' + Math.round(item.price).toLocaleString('es-EC') : 'Consultar';

    a.innerHTML =
      '<div class="property-image">' +
        '<img src="' + escHtml(imgSrc) + '" alt="' + escHtml(item.title) + '" loading="lazy">' +
        '<span class="property-badge">Verificado</span>' +
      '</div>' +
      '<div class="property-info">' +
        '<h3 class="property-title">' + escHtml(item.title) + '</h3>' +
        '<p class="property-location">\uD83D\uDCCD ' + escHtml(location) + '</p>' +
        '<div class="property-meta">' +
          '<div class="property-price">' +
            '<span class="price-label">Desde</span>' +
            '<span class="price-value">' + escHtml(price) + '<span class="price-period">/mes</span></span>' +
          '</div>' +
          '<span class="btn btn--small btn--outline" aria-hidden="true">Ver detalles</span>' +
        '</div>' +
      '</div>';

    return a;
  }

  function escHtml(str) {
    var div = document.createElement('div');
    div.textContent = str || '';
    return div.innerHTML;
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
