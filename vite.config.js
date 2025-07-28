import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',                         // dashboard
                'resources/js/app.js',
                'resources/landing/css/style.css',              // landing
                'resources/landing/css/animate.css',
                'resources/landing/js/index.js',
                'resources/landing/js/typewriter.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
    },
    base: process.env.NODE_ENV === 'production'
        ? '/esupportpro/public/build/'
        : '/',
});


// import { defineConfig } from 'vite'
// import laravel from 'laravel-vite-plugin'

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: [
//                 'resources/landing/css/style.css',
//                 'resources/landing/css/animate.css',
//                 'resources/landing/js/index.js',
//                 'resources/landing/js/typewriter.js'
//             ],
//             refresh: true,
//         }),
//     ],
//     build: {
//         outDir: 'public/build',
//     },
//     // Only use base for production builds
//     base: process.env.NODE_ENV === 'production' ? '/esupportpro/public/build/' : '/',
// })