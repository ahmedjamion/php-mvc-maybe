// ==========================
//  CACHE CONFIGURATION
// ==========================

// Name of the cache. Update the version (e.g., "v2") when assets change
// to force the browser to refresh stored files.
const CACHE_NAME = "v2";

// Files to store for offline access.
// These are fetched and cached when the Service Worker installs.
const ASSETS = [
  "/assets/styles/styles.css",
  "/assets/favicon/android-chrome-192x192.png",
  "/assets/favicon/android-chrome-512x512.png",
];

// ==========================
//  INSTALL EVENT
// ==========================
// Triggered once when the Service Worker is first registered.
// It pre-caches the listed assets so the app can work offline.
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) =>
      // Use Promise.allSettled so that even if one file fails to cache,
      // the others still get stored.
      Promise.allSettled(ASSETS.map((file) => cache.add(file)))
    )
  );
});

// ==========================
//  ACTIVATE EVENT
// ==========================
// Runs when the Service Worker takes control.
// It removes old caches to keep storage clean.
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      // Delete any cache that doesn’t match the current version.
      Promise.all(keys.map((key) => key !== CACHE_NAME && caches.delete(key)))
    )
  );
});

// ==========================
//  FETCH EVENT
// ==========================
// Intercepts all network requests.
// Serves cached files first, then fetches from the network if not cached.
self.addEventListener("fetch", (event) => {
  // Skip navigation requests (like full page loads).
  if (event.request.mode === "navigate") return;

  event.respondWith(
    caches.match(event.request).then(
      (cached) =>
        cached ||
        fetch(event.request)
          .then((response) => {
            // Clone the response because it can only be read once.
            const clone = response.clone();

            // Store the fetched file in the cache for next time.
            caches
              .open(CACHE_NAME)
              .then((cache) => cache.put(event.request, clone));

            return response;
          })
          // If offline, return cached version if available.
          .catch(() => cached)
    )
  );
});
