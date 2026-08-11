import {
    defineConfig
} from 'vite';
import { cpSync } from 'node:fs';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from "@tailwindcss/vite";

const copyTinymceSkins = () => ({
    name: 'copy-tinymce-skins',
    buildStart() {
        cpSync('node_modules/tinymce/skins', 'public/tinymce/skins', { recursive: true });
    },
    closeBundle() {
        cpSync('node_modules/tinymce/skins', 'public/tinymce/skins', { recursive: true });
    },
});

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/tinymce.js'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
                bunny('Fraunces', {
                    weights: [300, 400, 500, 600, 700],
                }),
                bunny('Inter', {
                    weights: [300, 400, 500, 600],
                }),
                bunny('JetBrains Mono', {
                    weights: [400, 500, 700],
                }),
            ],
        }),
        tailwindcss(),
        copyTinymceSkins(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
