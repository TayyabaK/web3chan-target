import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Bind to all network interfaces
        port: 5173,       // The port Vite will run on
        hmr: {
            host: 'localhost', // Set this to 'localhost' or the IP address of your Docker host
            port: 5173,        // The same port as your Vite server
        },
    },

});
