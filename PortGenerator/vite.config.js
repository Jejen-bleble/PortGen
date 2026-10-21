import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'], // Only include JS if you use it, or adjust as needed
            refresh: true,
        }),
    ],
});