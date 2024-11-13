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
                'slide-out': 'slideOut 10s ease-in-out forwards', // 10 secs. com transicao suave
            },
            keyframes: {
                slideOut: {
                    '0%': { transform: 'translateX(0)', opacity: '1' },
                    '90%': { transform: 'translateX(0)', opacity: '1' }, // Deixa o alerta visível até 90% do tempo
                    '100%': { transform: 'translateX(100%)', opacity: '0' }, // Slide rapido no final
                },
            },
        },
    },
    plugins: [],
};
