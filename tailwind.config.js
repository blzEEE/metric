/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                sky: colors.sky,
                teal: colors.teal,
                orange: colors.orange,
            }
        }
    },

    safelist: [
        {
            pattern: /(bg|text|border)-(sky|teal|orange|indigo|lime|amber)-(100|200|300|400|500|600|700|800|900)/,
        },
    ],

    plugins: [
        require('@tailwindcss/forms'),
    ],
};
