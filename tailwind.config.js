const plugin = require('tailwindcss/plugin');

module.exports = {
  content: [
    './resources/**/*.blade.php',
    './app/View/Components/**/*.php',
    './resources/**/*.js',
    './resources/**/*.jsx',
  ],
  safelist: [
    {
      // TW can't pickup dynamic classes in the Button React component
      pattern: /^mb-btn-/,
    },
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
      danger: '#ef4444',
      white: '#fff',
      black: '#020202',
      transparent: 'transparent',
      gray: {
        extralight: '#fafafa',
        light: '#d4d4d8',
        semi: '#71717a',
        dark: '#27272a',
      },
    },
    fontFamily: {
      sans: ['Inter', 'sans-serif'],
      serif: ['Inter', 'serif'],
      mono: ['Roboto Mono', 'monospace'],
    },
    spacing: {
      px: '1px',
      0: '0',
      1: '0.25rem',
      2: '0.5rem',
      3: '0.75rem',
      4: '1rem',
      5: '1.5rem',
      6: '2rem', //
      7: '3rem',
      8: '4rem',
      9: '6rem',
      10: '8rem',
      11: '10rem',
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
