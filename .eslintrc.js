module.exports = {
  extends: ['airbnb', 'prettier'],
  env: {
    browser: true,
    es2021: true,
  },
  rules: {
    'import/prefer-default-export': 'off',
    'react/jsx-props-no-spreading': 'off',
    'react/prop-types': 'off',
  },
};
