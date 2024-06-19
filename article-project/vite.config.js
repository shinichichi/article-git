import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import commonjs from 'vite-plugin-commonjs';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        commonjs(),
    ],
    optimizeDeps: {
        include: ['marked']
    }
});