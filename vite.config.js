import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

// Vite only *bundles* our hand-written CSS/JS — no Tailwind, no UI kit.
// (The assignment requires every line of CSS to be hand-authored.)
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
