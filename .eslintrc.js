module.exports = {
  root: true,
  extends: ['airbnb', 'airbnb-typescript', 'airbnb/hooks', 'prettier'],
  parserOptions: {
    project: './resources/js/tsconfig.eslint.json',
  },
  env: {
    browser: true,
    es2021: true,
  },
  rules: {
    'import/prefer-default-export': 'off',
    'react/jsx-props-no-spreading': 'off',
    'react/prop-types': 'off',
    'react/require-default-props': 'off',
    'react/button-has-type': 'off',
    'react/function-component-definition': 'off',
  },
};
