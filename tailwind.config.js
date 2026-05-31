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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    dark: '#0a2214',
                    medium: '#143521',
                    light: '#235235',
                    accent: '#c5a880',
                    'accent-dark': '#b39265',
                    bg: '#fdfbf7',
                },
                admin: {
                    dark: '#0f172a',
                    medium: '#1e293b',
                    light: '#334155',
                    accent: '#818cf8',
                    'accent-dark': '#6366f1',
                    bg: '#f8fafc',
                    muted: '#94a3b8',
                    success: '#22c55e',
                    warning: '#f59e0b',
                    danger: '#ef4444',
                }
            },
        },
    },

    plugins: [forms],
};
