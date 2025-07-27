import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/landing/css/style.css',
                'resources/landing/css/animate.css',
                'resources/landing/js/index.js',
                'resources/landing/js/typewriter.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
    },
    base: '/build/', // This ensures assets are served from /build/ path
});