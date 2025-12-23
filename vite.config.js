import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        // Optimasi untuk production
        cssCodeSplit: true,
        // Minifikasi (menggunakan esbuild sebagai default)
        minify: 'esbuild',
        // Chunk size warning limit
        chunkSizeWarningLimit: 1000,
    },
});
