import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                'body': [
                  'Inter',
                  'ui-sans-serif',
                  'system-ui',
                  // other fallback fonts
                ],
                'sans': [
                  'Inter',
                  'ui-sans-serif',
                  'system-ui',
                  // other fallback fonts
                ]
              }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('flowbite/plugin')],
};
