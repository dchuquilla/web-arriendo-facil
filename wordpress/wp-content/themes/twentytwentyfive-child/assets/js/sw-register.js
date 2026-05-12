if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/wp-content/themes/twentytwentyfive-child/assets/js/service-worker.js', {
      scope: '/'
    }).catch((error) => {
      console.debug('Service worker registration failed:', error);
    });
  });
}
