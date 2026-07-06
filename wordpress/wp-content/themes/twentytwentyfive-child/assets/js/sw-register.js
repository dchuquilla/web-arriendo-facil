if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    var conn = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    var canRegister = window.isSecureContext || /^(localhost|127\.0\.0\.1)$/.test(window.location.hostname);

    if (!canRegister || (conn && conn.saveData)) {
      return;
    }

    var register = function () {
      navigator.serviceWorker.register('/wp-content/themes/twentytwentyfive-child/assets/js/service-worker.js', {
        scope: '/wp-content/themes/twentytwentyfive-child/assets/js/'
      }).catch(() => {});
    };

    if (typeof window.requestIdleCallback === 'function') {
      window.requestIdleCallback(register, { timeout: 2500 });
      return;
    }

    window.setTimeout(register, 1200);
  });
}
