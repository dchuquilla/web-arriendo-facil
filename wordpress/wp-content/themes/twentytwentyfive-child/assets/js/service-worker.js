const CACHE_NAME = 'arriendo-facil-v1';
const urlsToCache = [
  '/',
  '/propiedades/',
  '/contacto/',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(urlsToCache).catch(() => {
        // Some URLs might fail, but we continue
      });
    })
  );
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

  // Only handle same-origin requests
  if (url.origin !== location.origin) {
    return;
  }

  // Skip POST requests and API calls
  if (request.method !== 'GET') {
    return;
  }

  // Skip admin/wp-admin
  if (url.pathname.includes('/wp-admin') || url.pathname.includes('/wp-login')) {
    return;
  }

  // Cache navigation requests (HTML pages)
  if (request.mode === 'navigate') {
    event.respondWith(
      caches.match(request).then((response) => {
        if (response) {
          // Return cached, but update in background
          fetch(request).then((freshResponse) => {
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(request, freshResponse.clone());
            });
          }).catch(() => {});
          return response;
        }

        return fetch(request).then((response) => {
          // Cache successful responses
          if (response && response.status === 200 && response.type === 'basic') {
            const responseToCache = response.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(request, responseToCache);
            });
          }
          return response;
        }).catch(() => {
          // Return cached response if fetch fails
          return caches.match(request);
        });
      })
    );
    return;
  }

  // Cache-first for assets (CSS, JS, images)
  if (request.destination === 'style' || request.destination === 'script' || request.destination === 'image') {
    event.respondWith(
      caches.match(request).then((response) => {
        return response || fetch(request).then((freshResponse) => {
          if (freshResponse && freshResponse.status === 200) {
            const responseToCache = freshResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(request, responseToCache);
            });
          }
          return freshResponse;
        });
      })
    );
  }
});
