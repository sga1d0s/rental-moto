const CACHE_NAME = 'motos-cache-v1';
const OFFLINE_URL = '/offline.html';

const ASSETS = [
  '/',
  OFFLINE_URL,
  '/css/app.css',
  '/js/app.js',
  '/manifest.json',
  '/icons/icon-192x192.png',
  '/icons/icon-512x512.png'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(ASSETS))
      .then(() => self.skipWaiting())  // activa inmediatamente la nueva SW
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(
        keys.filter(key => key !== CACHE_NAME)
            .map(key => caches.delete(key))
      )
    )
    .then(() => self.clients.claim())  // toma el control inmediato
  );
});

self.addEventListener('fetch', event => {
  const req = event.request;

  // Para navegación (HTML): Network First, fallback a offline.html
  if (req.mode === 'navigate') {
    event.respondWith(
      fetch(req)
        .then(res => {
          // cacheamos la nueva página
          const copy = res.clone();
          caches.open(CACHE_NAME).then(cache => cache.put(req, copy));
          return res;
        })
        .catch(() =>
          caches.match(req).then(cached => cached || caches.match(OFFLINE_URL))
        )
    );
    return;
  }

  // Para assets estáticos: Cache First
  event.respondWith(
    caches.match(req)
      .then(cached => cached || fetch(req).then(res => {
        // opcional: cachear nuevos assets
        return res;
      }))
  );
});