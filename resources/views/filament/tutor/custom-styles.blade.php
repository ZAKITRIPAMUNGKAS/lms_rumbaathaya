{{-- Custom styles for Filament Tutor Panel --}}
<style>
    /* Custom styles can be added here if needed */
</style>

@if(!app()->environment('production'))
{{-- Unregister service workers in development to prevent lag --}}
<script>
(function() {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function(registrations) {
            if (registrations.length > 0) {
                console.log('Development mode: Unregistering ' + registrations.length + ' service worker(s)...');
                registrations.forEach(function(registration) {
                    registration.unregister().then(function(success) {
                        if (success) {
                            console.log('Service Worker unregistered for development');
                        }
                    });
                });
            }
        });
        
        // Clear all caches in development
        if ('caches' in window) {
            caches.keys().then(function(cacheNames) {
                return Promise.all(
                    cacheNames.map(function(cacheName) {
                        return caches.delete(cacheName);
                    })
                );
            });
        }
    }
})();
</script>
@endif
