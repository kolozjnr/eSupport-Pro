import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                    'resources/js/app.js',
                    'resources/landing/css/style.css',     // landing page Tailwind CSS
                    'resources/landing/css/animate.css',     // landing page Tailwind CSS
                    'resources/landing/js/index.js',     // landing page Tailwind CSS
                    'resources/landing/js/typewriter.js',     // landing page Tailwind CSS
            ],
            //refresh: true,
              build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
    },
        }),
    ],
});
