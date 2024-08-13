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
              },
              colors: {
                mygreen: {
                    DEFAULT: '#3EB489',
                    light: '#A8E6CF',
                    dark: '#2A7F5E',
                    100: '#E6F7F1',
                    200: '#C1EAD9',
                    300: '#9BDEC1',
                    400: '#75D1A9',
                    500: '#4FC591',
                    600: '#3EB489',
                    700: '#2A7F5E',
                    800: '#1E5A43',
                    900: '#133628',
                },
            },
            animation: {
              fadeInUp: 'fadeInUp 2s ease-out', // Add custom animation here
            },
            keyframes: {
              fadeInUp: {
                '0%': { opacity: 0, transform: 'translateY(20px)' },
                '100%': { opacity: 1, transform: 'translateY(0)' },
              },
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('flowbite/plugin')],
};
