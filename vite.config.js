import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    base: '/esupportpro/public/build/',
    plugins: [
        laravel({
            input: [
                'resources/landing/css/style.css',
                'resources/landing/css/animate.css',
                'resources/landing/js/index.js',
                'resources/landing/js/typewriter.js'
            ],
            refresh: true,
        }),
    ],
})
