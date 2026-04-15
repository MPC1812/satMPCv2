import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // <--- Vital

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: true, // <--- Necesario para que el otro PC lo vea
        hmr: {
            host: '10.27.6.254',
        },
    },
    plugins: [
        tailwindcss(), // <--- Motor de diseño
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
