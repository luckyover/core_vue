/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution')

module.exports = {
  root: true,
  'extends': [
    'plugin:vue/vue3-essential',
    'eslint:recommended',
    '@vue/eslint-config-typescript',
    '@vue/eslint-config-prettier/skip-formatting'
  ],
  parserOptions: {
    ecmaVersion: 'latest'
  },
  rule: {
    'max-len': ['error', { 'code': 120 }],
    'indent': [2, 2],
    'trailing-comma': 0,
    'no-unused-vars': 'off',
    'no-extra-semi': 'error',
    'semi': ['error', 'never']
  }
}
