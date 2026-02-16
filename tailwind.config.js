import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // 👈 IMPORTANT: enable dark mode via 'class'

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',       
        // Optional: include JS files if you're using class names there
        './resources/js/**/*.js',
    ],

    safelist: [
        'bg-green-500',
        'bg-red-500',
        'text-white',
        'text-black',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Open Sans', ...defaultTheme.fontFamily.sans], // match Pavo's font
            },
            colors: {
                primary: '#1F9CA1',
            },
        },
    },

    plugins: [
        forms,
    ],
};
