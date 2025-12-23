/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Livewire/**/*.php",
    "./resources/views/livewire/**/*.blade.php",
    "./resources/views/components/**/*.blade.php",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#475569',
        'brand-orange': '#F97316', // Vibrant Orange for CTAs (EXACT from Next.js)
        'brand-blue': '#1E40AF',
        'brand-light': '#FEF3C7',
        'indigo-deep': '#4F46E5', // Deep Indigo for trust
        'orange-vibrant': '#F97316', // Vibrant Orange
        'slate-soft': '#F8FAFC', // Soft Slate surface
      },
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      backgroundImage: {
        'dots': 'radial-gradient(#cbd5e1 1px, transparent 1px)',
      },
      backgroundSize: {
        'dots': '20px 20px',
      },
      keyframes: {
        shake: {
          '0%, 100%': { transform: 'translateX(0)' },
          '10%, 30%, 50%, 70%, 90%': { transform: 'translateX(-10px)' },
          '20%, 40%, 60%, 80%': { transform: 'translateX(10px)' },
        },
        blob: {
          '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
          '33%': { transform: 'translate(30px, -20px) scale(1.1)' },
          '66%': { transform: 'translate(-40px, 30px) scale(1.2)' },
        },
        'fade-in-up': {
          '0%': { opacity: '0', transform: 'translateY(30px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        'fade-in': {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        shimmer: {
          '0%': { backgroundPosition: '-1000px 0' },
          '100%': { backgroundPosition: '1000px 0' },
        },
      },
      animation: {
        shake: 'shake 0.5s ease-in-out',
        blob: 'blob 20s ease-in-out infinite',
        'fade-in-up': 'fade-in-up 0.6s ease-out forwards',
        'fade-in': 'fade-in 0.8s ease-out forwards',
        float: 'float 3s ease-in-out infinite',
        shimmer: 'shimmer 2s infinite linear',
      },
      boxShadow: {
        'premium': '0 8px 30px rgba(0, 0, 0, 0.04), 0 0 0 1px rgba(0, 0, 0, 0.02)',
        'premium-lg': '0 12px 40px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.02)',
        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.37)',
        // EXACT shadows from Next.js globals.css
        'premium-exact': '0 10px 40px -10px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05)',
        'premium-lg-exact': '0 20px 60px -15px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05)',
      },
      borderRadius: {
        'glass': '2rem', // rounded-[2rem] from Next.js
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
  safelist: [
    // Critical classes that must not be purged
    'bg-brand-orange',
    'text-brand-orange',
    'bg-indigo-deep',
    'text-indigo-deep',
    'bg-white/70',
    'bg-white/80',
    'backdrop-blur-xl',
    'backdrop-blur-md',
    'bg-[#F8FAFC]',
    'bg-slate-soft',
    'animate-blob',
    'animate-float',
    'animate-shake',
    'shadow-indigo-500/10',
    'shadow-indigo-500/20',
    'shadow-indigo-500/30',
    'shadow-sky-500/20',
    'shadow-sky-500/30',
    'rounded-[2rem]',
    'rounded-[2.5rem]',
    'rounded-3xl',
  ],
}
