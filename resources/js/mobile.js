/**
 * Mobile App Integration Script
 * Handles Capacitor native features, bottom navigation, and mobile UX
 * LMS Rumba Athaya - Android PWA/APK
 */

// ===== CAPACITOR PLUGIN DETECTION =====
const isCapacitor = () => {
    return typeof window !== 'undefined' && window.Capacitor !== undefined;
};

const isMobile = () => {
    return window.innerWidth < 768 || /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
};

// ===== SPLASH SCREEN MANAGEMENT =====
function initSplashScreen() {
    if (!isMobile()) return;

    const splash = document.getElementById('app-splash');
    if (!splash) return;

    // Hide splash after page loads
    const hideSplash = () => {
        splash.classList.add('hidden');
        setTimeout(() => splash.remove(), 500);
    };

    if (document.readyState === 'complete') {
        setTimeout(hideSplash, 800);
    } else {
        window.addEventListener('load', () => setTimeout(hideSplash, 800));
    }
}

// ===== CAPACITOR NATIVE INIT =====
async function initCapacitor() {
    if (!isCapacitor()) return;

    try {
        // Initialize Status Bar
        if (window.Capacitor.Plugins?.StatusBar) {
            const { StatusBar } = window.Capacitor.Plugins;
            await StatusBar.setStyle({ style: 'DARK' });
            await StatusBar.setBackgroundColor({ color: '#0f172a' });
            await StatusBar.show();
        }

        // Initialize Splash Screen
        if (window.Capacitor.Plugins?.SplashScreen) {
            const { SplashScreen } = window.Capacitor.Plugins;
            setTimeout(() => SplashScreen.hide(), 1500);
        }

        // Mark body as capacitor platform
        document.documentElement.classList.add('capacitor-platform');

        // Initialize Push Notifications
        initPushNotifications();

        console.log('[Capacitor] Native plugins initialized');
    } catch (err) {
        console.warn('[Capacitor] Plugin init error:', err);
    }
}

// ===== PUSH NOTIFICATIONS =====
async function initPushNotifications() {
    if (!isCapacitor() || !window.Capacitor.Plugins?.PushNotifications) return;

    const { PushNotifications } = window.Capacitor.Plugins;

    try {
        const permResult = await PushNotifications.requestPermissions();
        if (permResult.receive !== 'granted') return;

        await PushNotifications.register();

        PushNotifications.addListener('registration', (token) => {
            console.log('[FCM] Token:', token.value);
            // Send token to Laravel backend
            sendFCMTokenToServer(token.value);
        });

        PushNotifications.addListener('pushNotificationReceived', (notification) => {
            console.log('[FCM] Notification received:', notification);
            showInAppNotification(notification.title, notification.body);
        });

        PushNotifications.addListener('pushNotificationActionPerformed', (action) => {
            console.log('[FCM] Action:', action);
            const data = action.notification.data;
            if (data?.url) {
                window.location.href = data.url;
            }
        });
    } catch (err) {
        console.warn('[FCM] Push notification init error:', err);
    }
}

// ===== SEND FCM TOKEN TO LARAVEL =====
async function sendFCMTokenToServer(token) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) return;

        await fetch('/api/device/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                fcm_token: token,
                platform: 'android',
                device_name: navigator.userAgent,
            }),
        });
    } catch (err) {
        // Silently fail — token registration is non-critical
    }
}

// ===== IN-APP NOTIFICATION TOAST =====
function showInAppNotification(title, body) {
    const toast = document.createElement('div');
    toast.className = 'push-notification-toast';
    toast.innerHTML = `
        <div class="push-notification-inner">
            <img src="/Logo.png" alt="Logo" class="push-icon" onerror="this.style.display='none'">
            <div class="push-content">
                <div class="push-title">${title || 'Notifikasi'}</div>
                <div class="push-body">${body || ''}</div>
            </div>
            <button class="push-close" onclick="this.closest('.push-notification-toast').remove()">✕</button>
        </div>
    `;

    // Add styles
    const style = document.createElement('style');
    style.textContent = `
        .push-notification-toast {
            position: fixed;
            top: calc(16px + env(safe-area-inset-top));
            left: 12px;
            right: 12px;
            z-index: 9999;
            animation: slide-down 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .push-notification-inner {
            background: white;
            border-radius: 16px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.05);
        }
        .push-icon { width: 40px; height: 40px; border-radius: 10px; object-fit: contain; }
        .push-content { flex: 1; }
        .push-title { font-weight: 700; font-size: 14px; color: #0f172a; }
        .push-body { font-size: 12px; color: #64748b; margin-top: 2px; }
        .push-close { background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 16px; padding: 4px; }
        @keyframes slide-down {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;

    if (!document.querySelector('#push-notification-styles')) {
        style.id = 'push-notification-styles';
        document.head.appendChild(style);
    }

    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 6000);
}

// ===== BOTTOM NAVIGATION ACTIVE STATE =====
function initBottomNav() {
    if (!isMobile()) return;

    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.mobile-bottom-nav-item');

    navItems.forEach(item => {
        const href = item.getAttribute('href');
        if (!href) return;

        const isActive = currentPath === href || currentPath.startsWith(href + '/');
        if (isActive) {
            item.classList.add('active');
        }
    });
}

// ===== HAPTIC FEEDBACK =====
async function hapticFeedback(style = 'light') {
    if (!isCapacitor() || !window.Capacitor.Plugins?.Haptics) return;

    try {
        const { Haptics, ImpactStyle } = window.Capacitor.Plugins;
        const styleMap = {
            light: ImpactStyle.Light,
            medium: ImpactStyle.Medium,
            heavy: ImpactStyle.Heavy,
        };
        await Haptics.impact({ style: styleMap[style] || ImpactStyle.Light });
    } catch (err) {
        // Silently fail
    }
}

// Add haptic to all buttons
function initHapticButtons() {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('button, [role="button"], .mobile-card-tap');
        if (btn) {
            hapticFeedback('light');
        }
    });
}

// ===== MOBILE CARD STAGGER ANIMATION =====
function initCardAnimations() {
    if (!isMobile()) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('mobile-animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.mobile-animate-in').forEach(el => {
        observer.observe(el);
    });
}

// ===== SWIPE TO CLOSE SIDEBAR =====
function initSwipeGestures() {
    if (!isMobile()) return;

    let startX = 0;
    let startY = 0;

    document.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    }, { passive: true });

    document.addEventListener('touchend', (e) => {
        const deltaX = e.changedTouches[0].clientX - startX;
        const deltaY = Math.abs(e.changedTouches[0].clientY - startY);

        // Swipe right to open sidebar
        if (startX < 20 && deltaX > 60 && deltaY < 100) {
            const sidebarToggle = document.querySelector('[\\@click="sidebarOpen = true"]');
            if (sidebarToggle) sidebarToggle.click();
        }

        // Swipe left to close sidebar
        if (deltaX < -60 && deltaY < 100) {
            const overlay = document.querySelector('[\\@click="sidebarOpen = false"]');
            if (overlay) overlay.click();
        }
    }, { passive: true });
}

// ===== VIEWPORT HEIGHT FIX (Mobile browsers with URL bar) =====
function initViewportFix() {
    const setVH = () => {
        document.documentElement.style.setProperty('--dvh', `${window.innerHeight * 0.01}px`);
    };
    setVH();
    window.addEventListener('resize', setVH);
    window.addEventListener('orientationchange', setVH);
}

// ===== INITIALIZE ALL =====
document.addEventListener('DOMContentLoaded', () => {
    initSplashScreen();
    initCapacitor();
    initBottomNav();
    initHapticButtons();
    initCardAnimations();
    initSwipeGestures();
    initViewportFix();

    console.log('[LMS] Mobile app initialized', {
        capacitor: isCapacitor(),
        mobile: isMobile(),
    });
});

// Export for use in other scripts
window.LMSMobile = {
    isCapacitor,
    isMobile,
    hapticFeedback,
    showInAppNotification,
};
