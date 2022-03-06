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
    spacing: {
      0: '0px',
      px: '1px',
      1: 'var(--space-3xs)',
      2: 'var(--space-2xs)',
      3: 'var(--space-xs)',
      4: 'var(--space-s)',
      5: 'var(--space-m)',
      6: 'var(--space-l)',
      7: 'var(--space-xl)',
      8: 'var(--space-2xl)',
      9: 'var(--space-3xl)',
    },
    fontSize: {
      xs: [
        'var(--step--2)',
        {
          lineHeight: '1.33',
          letterSpacing: 'normal',
        },
      ],
      sm: [
        'var(--step--1)',
        {
          lineHeight: '1.4',
          letterSpacing: 'normal',
        },
      ],
      base: [
        'var(--step-0)',
        {
          lineHeight: '1.5',
          letterSpacing: 'normal',
        },
      ],
      lg: [
        'var(--step-1)',
        {
          lineHeight: '1.55',
          letterSpacing: 'normal',
        },
      ],
      xl: [
        'var(--step-2)',
        {
          lineHeight: '1.33',
          letterSpacing: 'normal',
        },
      ],
      '2xl': [
        'var(--step-3)',
        {
          lineHeight: '1.33',
          letterSpacing: 'normal',
        },
      ],
      '3xl': [
        'var(--step-4)',
        {
          lineHeight: '1.2',
          letterSpacing: '-.025em',
        },
      ],
      '4xl': [
        'var(--step-5)',
        {
          lineHeight: '1',
          letterSpacing: '-.025em',
        },
      ],
    },
    fontFamily: {
      sans: ['Inter', 'sans-serif'],
      serif: ['Inter', 'serif'],
      mono: ['Roboto Mono', 'monospace'],
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
