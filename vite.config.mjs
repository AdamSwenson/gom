import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';
export default defineConfig({
    resolve: {
        extensions: ['.mjs', '.js', '.mts', '.ts', '.jsx', '.tsx', '.json', '.vue'],
    },
    build: {
        commonjsOptions: {
            include: [/node_modules/, /resources\/assets\/js/],
            transformMixedEsModules: true,
        },
    },
    plugins: [

        laravel({
            input: [
                'resources/assets/js/development/entries/new-setup.js',
                'resources/assets/js/development/entries/new-grading.js',
                'resources/assets/js/development/entries/new-public-feedback.js',
            ],
            refresh: true,
        }),
        vue(),
    ],


});
