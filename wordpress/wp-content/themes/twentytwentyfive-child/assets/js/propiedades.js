(function () {
  'use strict';

  var POLL_INTERVAL = 30000;
  var apiUrl = (window.afPropiedades && window.afPropiedades.apiUrl) || '/wp-json/af/v1/accommodations/search';
  var currentFilters = (window.afPropiedades && window.afPropiedades.filters) || {};
  var baselineIds = [];
  var pollTimer = null;
  var initialized = false;

  function init() {
    fetchAllIds(function (ids) {
      baselineIds = ids;
      initialized = true;
      startPolling();
    });

    document.addEventListener('visibilitychange', function () {
      if (document.hidden) {
        stopPolling();
      } else if (initialized) {
        startPolling();
      }
    });
  }

  function fetchAllIds(callback) {
    var body = { sort: 'newest', per_page: 100, page: 1 };
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
        if (data.success && data.results) {
          callback(data.results.map(function (r) { return r.id; }));
        } else {
          callback([]);
        }
      })
      .catch(function () { callback([]); });
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
    var body = { sort: 'newest', per_page: 100, page: 1 };
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

        var newItems = data.results.filter(function (item) {
          return baselineIds.indexOf(item.id) === -1;
        });

        if (newItems.length) {
          appendNewCards(newItems);
          newItems.forEach(function (item) {
            baselineIds.push(item.id);
          });
        }
      })
      .catch(function () {});
  }

  function appendNewCards(items) {
    var grid = document.querySelector('.properties-grid');
    if (!grid) return;

    var noProps = grid.querySelector('.no-properties');
    if (noProps) noProps.remove();

    items.forEach(function (item) {
      var card = createCard(item);
      card.classList.add('af-fade-in');
      grid.prepend(card);
    });
  }

  function createCard(item) {
    var a = document.createElement('a');
    a.href = item.url;
    a.className = 'property-card';

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
