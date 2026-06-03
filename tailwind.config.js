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
                    dark: '#154734', // Elegant Hunter Green (less black)
                    medium: '#1E6348', // Medium rich green
                    light: '#288761', // Lighter accent green
                    accent: '#D4AF37', // Richer metallic gold
                    'accent-dark': '#AA8C2C', // Deeper gold
                    bg: '#F5F0E6', // Warmer, richer beige/ivory
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
