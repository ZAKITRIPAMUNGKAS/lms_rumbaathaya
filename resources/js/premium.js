/**
 * Premium JavaScript - International Standards
 * Performance, Accessibility, and UX Enhancements
 */

// ============================================
// PERFORMANCE OPTIMIZATIONS
// ============================================

// Lazy loading images with Intersection Observer
document.addEventListener('DOMContentLoaded', function() {
    // Lazy load images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        img.classList.add('animate-fade-in');
                        observer.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Smooth scroll with offset for fixed navbar
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offset = 80; // Navbar height
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});

// ============================================
// ACCESSIBILITY ENHANCEMENTS
// ============================================

// Keyboard navigation for dropdowns
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('[data-dropdown]');
    
    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('[data-dropdown-trigger]');
        const menu = dropdown.querySelector('[data-dropdown-menu]');
        
        if (trigger && menu) {
            // Toggle on click
            trigger.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
            
            // Keyboard navigation
            trigger.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    menu.classList.toggle('hidden');
                }
            });
            
            // Close on outside click
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });
            
            // Close on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    menu.classList.add('hidden');
                }
            });
        }
    });
});

// Skip to main content
document.addEventListener('DOMContentLoaded', function() {
    const skipLink = document.querySelector('.skip-to-main');
    if (skipLink) {
        skipLink.addEventListener('click', function(e) {
            e.preventDefault();
            const main = document.querySelector('main') || document.querySelector('#main-content');
            if (main) {
                main.focus();
                main.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
});

// ============================================
// PERFORMANCE MONITORING
// ============================================

// Web Vitals tracking (optional - can be integrated with analytics)
if ('PerformanceObserver' in window) {
    try {
        const perfObserver = new PerformanceObserver((list) => {
            for (const entry of list.getEntries()) {
                // Log performance metrics (can be sent to analytics)
                console.log(entry.name, entry.value);
            }
        });
        
        perfObserver.observe({ entryTypes: ['measure', 'navigation'] });
    } catch (e) {
        // Performance Observer not supported
    }
}

// ============================================
// FORM VALIDATION ENHANCEMENTS
// ============================================

// Real-time form validation with ARIA
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            // Real-time validation
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('error')) {
                    validateField(this);
                }
            });
        });
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                const firstError = form.querySelector('.error');
                if (firstError) {
                    firstError.focus();
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    });
    
    function validateField(field) {
        const value = field.value.trim();
        const type = field.type;
        const required = field.hasAttribute('required');
        let isValid = true;
        let errorMessage = '';
        
        // Required validation
        if (required && !value) {
            isValid = false;
            errorMessage = 'Field ini wajib diisi';
        }
        
        // Email validation
        if (type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Format email tidak valid';
            }
        }
        
        // Phone validation
        if (type === 'tel' && value) {
            const phoneRegex = /^[0-9+\-\s()]+$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'Format nomor telepon tidak valid';
            }
        }
        
        // Update UI
        if (isValid) {
            field.classList.remove('error');
            field.setAttribute('aria-invalid', 'false');
            removeErrorMessage(field);
        } else {
            field.classList.add('error');
            field.setAttribute('aria-invalid', 'true');
            showErrorMessage(field, errorMessage);
        }
        
        return isValid;
    }
    
    function showErrorMessage(field, message) {
        removeErrorMessage(field);
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-red-600 text-sm mt-1';
        errorDiv.id = `${field.id || field.name}-error`;
        errorDiv.textContent = message;
        errorDiv.setAttribute('role', 'alert');
        
        field.parentNode.appendChild(errorDiv);
        field.setAttribute('aria-describedby', errorDiv.id);
    }
    
    function removeErrorMessage(field) {
        const existingError = field.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        field.removeAttribute('aria-describedby');
    }
});

// ============================================
// LOADING STATES
// ============================================

// Show loading state on form submission
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.setAttribute('aria-busy', 'true');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Memproses...';
                
                // Re-enable after 10 seconds (fallback)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.removeAttribute('aria-busy');
                    submitBtn.textContent = originalText;
                }, 10000);
            }
        });
    });
});

// ============================================
// MOBILE MENU ENHANCEMENTS
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            const isHidden = mobileMenu.classList.contains('hidden');
            
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                mobileMenuToggle.setAttribute('aria-expanded', 'true');
                mobileMenuToggle.setAttribute('aria-label', 'Tutup menu');
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                mobileMenuToggle.setAttribute('aria-label', 'Buka menu');
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!mobileMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Close menu on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
});

// ============================================
// SCROLL ANIMATIONS
// ============================================

// Intersection Observer for scroll animations
document.addEventListener('DOMContentLoaded', function() {
    if ('IntersectionObserver' in window) {
        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                    animationObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        document.querySelectorAll('.scroll-animate').forEach(el => {
            animationObserver.observe(el);
        });
    }
});

// ============================================
// PWA SUPPORT
// ============================================

// Only register service worker in production
// In development, service workers can cause lag by intercepting all requests
const isProduction = window.location.hostname !== 'localhost' && 
                     window.location.hostname !== '127.0.0.1' &&
                     !window.location.hostname.includes('.local') &&
                     !window.location.hostname.includes('.test');

if ('serviceWorker' in navigator && isProduction) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('SW registered: ', registration);
            })
            .catch(registrationError => {
                console.log('SW registration failed: ', registrationError);
            });
    });
} else if ('serviceWorker' in navigator && !isProduction) {
    // Unregister any existing service workers in development
    window.addEventListener('load', () => {
        navigator.serviceWorker.getRegistrations().then(registrations => {
            registrations.forEach(registration => {
                registration.unregister().then(success => {
                    if (success) {
                        console.log('Service Worker unregistered for development');
                    }
                });
            });
        });
    });
}

// ============================================
// ERROR HANDLING
// ============================================

// Global error handler
window.addEventListener('error', function(e) {
    console.error('Global error:', e.error);
    // Can be sent to error tracking service
});

// Unhandled promise rejection handler
window.addEventListener('unhandledrejection', function(e) {
    console.error('Unhandled promise rejection:', e.reason);
    // Can be sent to error tracking service
});

