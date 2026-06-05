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
            fontFamily: {
                sans: ['Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    green: {
                        deep: '#0D3B2E',
                        mid: '#1A5C45',
                        light: '#2E8B57',
                        verydeep: '#091f19',
                    },
                    gold: {
                        DEFAULT: '#C9A84C',
                        light: '#E8D08A',
                        dark: '#8B6914',
                    },
                    cream: {
                        DEFAULT: '#FBF6EC',
                        dark: '#F0E8D0',
                    },
                    text: {
                        dark: '#1A1208',
                        mid: '#4A3728',
                    }
                },
                rose: {
                    50: '#FBF6EC', // Cream
                    100: '#F0E8D0', // Cream Dark
                    200: '#E8D08A', // Gold Light
                    300: '#E8D08A',
                    400: '#C9A84C', // Gold Accent
                    500: '#C9A84C', // Gold Primary
                    600: '#8B6914', // Gold Dark
                    700: '#8B6914',
                    800: '#8B6914',
                    900: '#8B6914',
                },
                pink: {
                    50: '#FBF6EC',
                    100: '#F0E8D0',
                    200: '#E8D08A',
                    300: '#E8D08A',
                    400: '#C9A84C',
                    500: '#8B6914', // Gold Dark
                    600: '#8B6914',
                    700: '#8B6914',
                },
                slate: {
                    50: '#FBF6EC', // Cream Background
                    100: '#F0E8D0', // Cream Dark Borders
                    200: '#E8D08A',
                    300: '#E8D08A',
                    400: '#4A3728', // Medium Text
                    500: '#4A3728',
                    600: '#4A3728',
                    700: '#1A1208', // Text Dark
                    800: '#0D3B2E', // Deep Green Headers/Text
                    900: '#091f19', // Very Deep Green Footer
                },
            },
        },
    },

    plugins: [forms],
};
