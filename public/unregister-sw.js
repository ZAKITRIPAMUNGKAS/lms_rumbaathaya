/**
 * Service Worker Unregister Script
 * Run this script in browser console to unregister all service workers
 * Or include this in your HTML during development
 */

(function() {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function(registrations) {
            if (registrations.length === 0) {
                console.log('No service workers found');
                return;
            }
            
            console.log('Found ' + registrations.length + ' service worker(s), unregistering...');
            
            registrations.forEach(function(registration) {
                registration.unregister().then(function(success) {
                    if (success) {
                        console.log('Service Worker unregistered successfully');
                    } else {
                        console.log('Service Worker unregistration failed');
                    }
                }).catch(function(error) {
                    console.error('Error unregistering service worker:', error);
                });
            });
        });
        
        // Also clear all caches
        if ('caches' in window) {
            caches.keys().then(function(cacheNames) {
                return Promise.all(
                    cacheNames.map(function(cacheName) {
                        console.log('Deleting cache:', cacheName);
                        return caches.delete(cacheName);
                    })
                );
            }).then(function() {
                console.log('All caches cleared');
            });
        }
    } else {
        console.log('Service Workers not supported');
    }
})();
