import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Open Sans"', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'slide-in-out': 'slideIn 0.5s ease-out, slideOut 0.5s ease-in 3s forwards',
            },
            keyframes: {
                slideOut: {
                    '0%': { transform: 'translateX(0)', opacity: '1' },
                    '90%': { transform: 'translateX(0)', opacity: '1' }, 
                    '100%': { transform: 'translateX(100%)', opacity: '0' }, 
                },
                slideIn: {
                    '0%': { transform: 'translateX(100%)', opacity: '0' },
                    '100%': { transform: 'translateX(0)', opacity: '1' },   
                },
            },
        },
    },
    plugins: [],
};
