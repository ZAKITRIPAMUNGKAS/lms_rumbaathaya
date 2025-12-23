import './bootstrap';
import './premium';

// Alpine.js is included by Livewire 3 automatically
// We just need to add the Intersect plugin to Livewire's Alpine instance
document.addEventListener('livewire:init', () => {
    import('@alpinejs/intersect').then(({ default: intersect }) => {
        if (window.Alpine) {
            window.Alpine.plugin(intersect);
        }
    });
});

// For non-Livewire pages (like landing page), initialize Alpine manually
if (typeof window.Livewire === 'undefined') {
    import('alpinejs').then(({ default: Alpine }) => {
        import('@alpinejs/intersect').then(({ default: intersect }) => {
            Alpine.plugin(intersect);
            window.Alpine = Alpine;
            Alpine.start();
        });
    });
}
