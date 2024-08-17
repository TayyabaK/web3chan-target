import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        'node_modules/preline/dist/*.js',
        './app/Filament/**/*.php',
        './app/Livewire/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/robsontenorio/mary/src/View/Components/**/*.php',
    ],

    safelist: [
        {
            pattern: /grid-cols-\d+/,
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                '8xl': '90rem',
                '9xl': '100rem',
            },
            colors: {
                brand: {
                    primary: '#5D4B97',
                    secondary: '#1D1635',
                    accent: '#8125FF',
                    darkest: '#060117',
                },
                neutral: {
                    DEFAULT: '#A2A2A2',
                    lightest: '#F6F6F6',
                },
                accent: {
                    magenta: '#D632FF',
                    green: '#5AE518',
                },
            },
        },
    },

    daisyui: {
        base: false,
    },

    plugins: [forms, require('preline/plugin'), require('daisyui')],
};
