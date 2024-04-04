<? require('settings.php'); ?>
var cacheName = 'AlecsCP';
var filesToCache = [
	'style.css?v=<? echo $version; ?>',
	'AlecsCP.css?v=<? echo $version; ?>',
	'scripts.js?v=<? echo $version; ?>',
];
self.addEventListener('install', function(e) {
  console.log('ServiceWorker > Installing...');
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      console.log('ServiceWorker > Caching app shell...');
      return cache.addAll(filesToCache);
    })
  );
  console.log('ServiceWorker > Finishing...');
});
self.addEventListener('activate',  event => {
  event.waitUntil(self.clients.claim());
});
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request, {ignoreSearch:true}).then(response => {
      return response || fetch(event.request);
    })
  );
});