/** @type {import('tailwindcss').Config} */

export default {

    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {

        extend: {

            colors: {

                primary: '#4B2E1F',
                secondary: '#6B4A3A',
                accent: '#C87A2A',
                background: '#FDF8F4',
                soft: '#E9DCCB',

            },

            fontFamily: {

                heading: ['"Playfair Display"', 'serif'],
                body: ['Inter', 'sans-serif'],

            },

            boxShadow: {

                soft: '0 4px 30px rgba(0,0,0,0.04)',

            }

        },

    },

    plugins: [],
}