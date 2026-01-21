import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                //css
                'resources/css/app.css',
                'resources/scss/main.scss',

                //js
                'resources/js/app.js',
                'resources/js/main.js'
            ],
            refresh: true,
        }),
    ],
});