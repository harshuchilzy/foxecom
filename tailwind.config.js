/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        themeblack: '#0B0E2D',
        blue_secondary: '#1275EE',
      },
      fontFamily: {
        sans: ['Source Sans 3', 'sans-serif'],
        hanken: ['Hanken Grotesk', 'sans-serif'],
        inter: ['Inter', 'sans-serif'],
        cal: ['Cal Sans', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

