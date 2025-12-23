/**
 * Phosphor Icons Local Loader
 * Loads all icon stylesheets locally
 */
(function() {
    'use strict';
    
    // Base path for Phosphor Icons
    const basePath = '/phosphor-icons';
    
    // Icon weights to load
    const weights = ['regular', 'thin', 'light', 'bold', 'fill', 'duotone'];
    
    // Function to load CSS
    function loadCSS(href) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        document.head.appendChild(link);
    }
    
    // Load all icon weights
    weights.forEach(weight => {
        loadCSS(`${basePath}/${weight}/style.css`);
    });
})();
