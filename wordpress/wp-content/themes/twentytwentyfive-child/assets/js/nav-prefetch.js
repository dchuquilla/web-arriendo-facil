(function () {
  var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
  var supportsHover = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  if (!supportsHover || (conn && (conn.saveData || /2g/.test(conn.effectiveType || "")))) {
    return;
  }

  var prefetched = new Set();
  var hoverTimer = null;

  function isCurrentPage(url) {
    try {
      var current = new URL(window.location.href);
      var next = new URL(url, window.location.origin);

      return current.pathname === next.pathname && current.search === next.search;
    } catch (e) {
      return false;
    }
  }

  function isPrefetchCandidate(url) {
    try {
      var u = new URL(url, window.location.origin);
      if (u.origin !== window.location.origin) return false;
      if (u.hash && u.pathname === window.location.pathname && u.search === window.location.search) return false;
      if (u.pathname.indexOf('/wp-admin') !== -1 || u.pathname.indexOf('/wp-login') !== -1) return false;
      if (isCurrentPage(u.href)) return false;
      if (u.searchParams.has("accommodation")) return true;
      if (/\/propiedades\/?$/.test(u.pathname)) return true;
      return false;
    } catch (e) {
      return false;
    }
  }

  function prefetch(url) {
    if (!url || prefetched.has(url) || !isPrefetchCandidate(url)) return;
    prefetched.add(url);

    if (document.head && document.createElement) {
      var link = document.createElement('link');
      link.rel = 'prefetch';
      link.href = url;
      link.as = 'document';
      document.head.appendChild(link);
      return;
    }

    fetch(url, {
      method: 'GET',
      credentials: 'same-origin',
      cache: 'force-cache'
    }).catch(function () {});
  }

  function handleLinkEvent(event) {
    var link = event.target && event.target.closest ? event.target.closest("a[href]") : null;
    if (!link || link.target === '_blank' || link.hasAttribute('download')) return;

    window.clearTimeout(hoverTimer);
    hoverTimer = window.setTimeout(function () {
      if (document.visibilityState === 'visible') {
        prefetch(link.href);
      }
    }, 120);
  }

  document.addEventListener('mouseover', handleLinkEvent, { passive: true });
  document.addEventListener('focusin', handleLinkEvent);
})();
