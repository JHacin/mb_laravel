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
      'primary-dark': '#c2643d',
      secondary: '#a88b8a',
      'secondary-dark': '#977d7c',
      // info: '#51a3a3',
      // warning: '#dfcc74',
      // success: '#c3e991',
      white: '#fff',
      black: '#020202',
      transparent: 'transparent',
      gray: {
        extralight: '#f4f4f5',
        light: '#d4d4d8',
        semi: '#71717a',
        dark: '#27272a',
      },
    },
    fontFamily: {
      sans: ['Inter', 'sans-serif'],
      serif: ['Inter', 'serif'],
      mono: ['Roboto Mono', 'monospace']
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
