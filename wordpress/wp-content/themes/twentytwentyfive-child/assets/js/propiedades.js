(function () {
  'use strict';

  var BASE_POLL_INTERVAL = 90000;
  var MAX_POLL_ATTEMPTS = 1;
  var apiUrl = (window.afPropiedades && window.afPropiedades.apiUrl) || '/wp-json/af/v1/accommodations/search';
  var currentFilters = (window.afPropiedades && window.afPropiedades.filters) || {};
  var baselineIds = [];
  var pollTimer = null;
  var initialized = false;
  var pollAttempts = 0;
  var inFlightController = null;

  function getPollingInterval() {
    var interval = BASE_POLL_INTERVAL * 2;

    if (window.matchMedia && window.matchMedia('(max-width: 768px)').matches) {
      interval = Math.max(interval, 120000);
    }

    if (navigator.connection && navigator.connection.saveData) {
      interval = Math.max(interval, 240000);
    }

    return interval;
  }

  function shouldPoll() {
    var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

    if (document.hidden) {
      return false;
    }

    if (conn && (conn.saveData || /2g/.test(conn.effectiveType || ''))) {
      return false;
    }

    return true;
  }

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
    var body = { sort: 'newest', per_page: 60, page: 1 };
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
    if (pollAttempts >= MAX_POLL_ATTEMPTS) return;
    if (!shouldPoll()) return;

    pollTimer = window.setTimeout(function () {
      pollTimer = null;
      checkForUpdates();
    }, getPollingInterval());
  }

  function stopPolling() {
    if (pollTimer) {
      clearTimeout(pollTimer);
      pollTimer = null;
    }
  }

  function checkForUpdates() {
    if (!shouldPoll() || pollAttempts >= MAX_POLL_ATTEMPTS) {
      stopPolling();
      return;
    }

    if (inFlightController) {
      inFlightController.abort();
    }

    inFlightController = new AbortController();

    var body = { sort: 'newest', per_page: 30, page: 1 };
    if (currentFilters.location) body.location = currentFilters.location;
    if (currentFilters.price_min) body.price_min = parseFloat(currentFilters.price_min);
    if (currentFilters.price_max) body.price_max = parseFloat(currentFilters.price_max);
    if (currentFilters.property_type) body.property_type = currentFilters.property_type;

    fetch(apiUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body),
      signal: inFlightController.signal,
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (!data.success || !data.results) return;

        pollAttempts += 1;

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
      .catch(function () {})
      .finally(function () {
        inFlightController = null;
      });
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
    var a = document.createElement('article');
    a.className = 'property-card';

    var imgSrc = item.image_url || (window.afPropiedades && window.afPropiedades.placeholder) || '';
    var location = item.location || 'Ubicación no especificada';
    var price = item.price > 0 ? '$' + Math.round(item.price).toLocaleString('es-EC') : 'Consultar';

    a.innerHTML =
      '<div class="property-image">' +
        '<a href="' + escHtml(item.url) + '" aria-label="' + escHtml(item.title) + '">' +
          '<img src="' + escHtml(imgSrc) + '" alt="' + escHtml(item.title) + '" loading="lazy">' +
        '</a>' +
        '<span class="property-badge">Verificado</span>' +
      '</div>' +
      '<div class="property-info">' +
        '<h3 class="property-title"><a href="' + escHtml(item.url) + '">' + escHtml(item.title) + '</a></h3>' +
        '<p class="property-location">\uD83D\uDCCD ' + escHtml(location) + '</p>' +
        '<div class="property-meta">' +
          '<div class="property-price">' +
            '<span class="price-label">Desde</span>' +
            '<span class="price-value">' + escHtml(price) + '<span class="price-period">/mes</span></span>' +
          '</div>' +
          '<div class="af-reserve-actions">' +
            '<button type="button" class="btn btn--small btn--primary" data-af-reserve-trigger data-af-accommodation-id="' + escHtml(String(item.id || '')) + '" data-af-accommodation-title="' + escHtml(item.title) + '">Reservar</button>' +
            '<a href="' + escHtml(item.url) + '" class="btn btn--small btn--outline">Ver detalles</a>' +
          '</div>' +
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
