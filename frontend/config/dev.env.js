'use strict'

const merge = require('webpack-merge')
const prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  CLIENT_ID: '3',
  SCOPE: '"*"',
  API_URL: '"http://vikas-builder-api.com"',
  CLIENT_SECRET: '"0ytbxt6uTkOBHOCeHOn8nke0nKC9iU90xfhLKP94"'
})
