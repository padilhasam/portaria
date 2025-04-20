import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/login.css',
                'resources/js/app.js',
                'resources/js/mascara.js',
                'resources/js/validarCPF.js',
                'resources/js/tom-select-init.js',
            ],
            refresh: true,
        }),
    ],
});
