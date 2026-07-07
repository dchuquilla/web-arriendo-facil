const CACHE_NAME = 'arriendo-facil-static-v3';
const ASSET_DESTINATIONS = new Set(['style', 'script', 'image', 'font']);

self.addEventListener('install', (event) => {
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  if (url.origin !== location.origin) {
    return;
  }

  if (request.method !== 'GET') {
    return;
  }

  if (
    request.mode === 'navigate' ||
    url.pathname.includes('/wp-admin') ||
    url.pathname.includes('/wp-login') ||
    url.pathname.includes('/wp-json/') ||
    url.search
  ) {
    return;
  }

  if (!ASSET_DESTINATIONS.has(request.destination) && !url.pathname.includes('/wp-content/')) {
    return;
  }

  event.respondWith(
    caches.match(request).then((response) => {
      if (response) {
        return response;
      }

      return fetch(request).then((freshResponse) => {
        if (freshResponse && freshResponse.status === 200 && freshResponse.type === 'basic') {
          const responseToCache = freshResponse.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(request, responseToCache);
          });
        }

        return freshResponse;
      });
    })
  );
});
