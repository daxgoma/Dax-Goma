/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './src/**/*.{html,js,php}',
    './public/**/*.html',
    './public/**/*.php',
    ],
  theme: {
    extend: {
      colors: {
        background: '#ffffff',
        text: '#000000',
      },
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
      borderWidth: {
        '3': '3px',
      },
    },
  },
  plugins: [],
}