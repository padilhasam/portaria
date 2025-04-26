import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import copy from 'rollup-plugin-copy'; // <-- plugin para copiar favicon

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
        copy({
            targets: [
                { src: 'resources/images/favicon.ico', dest: 'public' }
            ],
            hook: 'writeBundle'
        })
    ],
});
