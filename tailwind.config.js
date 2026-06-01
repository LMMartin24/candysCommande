import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                // New palette provided by user
                primary: '#de4d86',   // rose foncé
                accent: '#f29da4',    // rose classique
                paper: '#f7cacd',     // rose clair
                muted: '#85e6f9',     // bleu clair
                cafe: '#f29da4',      // mapped to rose classique
                dark: '#64113f',      // violet foncé
                page: '#EFE6DD'
            },
            fontFamily: {
                sans: ['Archivo Black', ...defaultTheme.fontFamily.sans],
                titan: ['Archivo Black', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins']
            },
        },
    },

    plugins: [forms],
};
