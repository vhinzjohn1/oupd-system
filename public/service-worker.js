// const CACHE_NAME = "my-site-cache-v1";
// const urlsToCache = [
//     "/css/fontawesome.min.css",
//     "/css/adminlte.min.css",
//     "/js/adminlte.min.js",
// ];

// self.addEventListener("install", function (event) {
//     // Perform install steps
//     event.waitUntil(
//         caches.open(CACHE_NAME).then(function (cache) {
//             console.log("Opened cache");
//             return cache.addAll(urlsToCache);
//         })
//     );
// });

// self.addEventListener("fetch", function (event) {
//     var requestUrl = new URL(event.request.url);

//     // Exclude requests for external resources like jQuery
//     if (requestUrl.origin !== location.origin) {
//         return;
//     }

//     event.respondWith(
//         caches.match(event.request).then(function (response) {
//             return response || fetch(event.request);
//         })
//     );
// });

// self.addEventListener("activate", function (event) {
//     let cacheWhitelist = ["pages-cache-v1", "blog-posts-cache-v1"];

//     event.waitUntil(
//         caches.keys().then(function (cacheNames) {
//             return Promise.all(
//                 cacheNames.map(function (cacheName) {
//                     if (cacheWhitelist.indexOf(cacheName) === -1) {
//                         return caches.delete(cacheName);
//                     }
//                 })
//             );
//         })
//     );
// });
