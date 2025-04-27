import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    content: [
        "./resources/**/*.blade.php", // Mencakup semua file Blade
        "./resources/**/*.js",       // Mencakup file JS jika ada kelas di sana
        "./resources/**/*.vue",       // Jika Anda menggunakan Vue
    ],
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
