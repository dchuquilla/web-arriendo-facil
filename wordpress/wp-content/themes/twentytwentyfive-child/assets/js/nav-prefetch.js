(function () {
  var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
  if (conn && (conn.saveData || /2g/.test(conn.effectiveType || ""))) {
    return;
  }

  var prefetched = new Set();

  function isPrefetchCandidate(url) {
    try {
      var u = new URL(url, window.location.origin);
      if (u.origin !== window.location.origin) return false;
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

    fetch(url, {
      method: "GET",
      credentials: "same-origin",
      cache: "force-cache",
    }).catch(function () {
      // Silent failure: prefetch is a best-effort optimization.
    });
  }

  function handleLinkEvent(event) {
    var link = event.target && event.target.closest ? event.target.closest("a[href]") : null;
    if (!link) return;
    prefetch(link.href);
  }

  document.addEventListener("mouseover", handleLinkEvent, { passive: true });
  document.addEventListener("touchstart", handleLinkEvent, { passive: true });
  document.addEventListener("mousedown", handleLinkEvent, { passive: true });
})();
