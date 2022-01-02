const plugin = require('tailwindcss/plugin');

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './app/View/Components/**/*.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    colors: {
      primary: '#d76f44',
      secondary: '#a88b8a',
      white: '#fff',
      black: '#000',
      transparent: 'transparent',
      gray: {
        50: '#fafafa',
        100: '#f4f4f5',
        200: '#e4e4e7',
        300: '#d4d4d8',
        400: '#a1a1aa',
        500: '#71717a',
        600: '#52525b',
        700: '#3f3f46',
        800: '#27272a',
        900: '#18181b',
      },
    },
    fontFamily: {
      sans: ['Inter', 'sans-serif'],
      serif: ['Inter', 'serif'],
    },
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
    plugin(function ({ addVariant }) {
      addVariant('disabled', '[disabled]');
    }),
  ],
};
