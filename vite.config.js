import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/application.jsx',
                'resources/js/shifts.jsx',
                'resources/js/company-users.jsx',
            ],
            refresh: true,
        }),
        react(),
    ],
});
