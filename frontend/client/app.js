import 'expose-loader?$!expose-loader?jQuery!jquery'
import 'bootstrap'
import 'admin-lte'

import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueAuth from '@websanova/vue-auth'
import NProgress from 'vue-nprogress'
import { sync } from 'vuex-router-sync'
import App from './App.vue'
import router from './router'
import store from './store'
// import * as filters from './filters'
// import { TOGGLE_SIDEBAR } from 'vuex-store/mutation-types'

Vue.router = router
Vue.use(VueAxios, axios)
Vue.use(require('vue-moment'))

// node_modules/@websanova/vue-auth/src/auth.js
Vue.use(VueAuth, {
  auth: {
    authRedirect: '/',
    request: function (req, token) {
      if (req.url.indexOf('google') === -1) {
        this.options.http._setHeaders.call(this, req, {Authorization: 'Bearer ' + token})
      }
    },
    response: function (res) {
      // console.log(res)
      // Get Token from response body
      return res.data.access_token
    }
  },
  http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
  router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
  fetchData: { url: process.env.API_URL + '/api/me', method: 'GET' },
  loginData: { url: process.env.API_URL + '/oauth/token', method: 'POST' },
  refreshData: { enabled: false },
  rolesVar: 'role',
  googleData: {url: 'auth/google/', method: 'POST', redirect: '/'},
  googleOauth2Data: {
    // redirect: function () { return process.env.API_URL + '/login/auth/google' },
    clientId: '226754854512-cgjfs4docc9kk5th6v7vtlssq8gpidfe.apps.googleusercontent.com',
    scope: 'https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
  }
})
// Client secret
// Mlw-qnpI_L_P8kNUclTm1UYE
Vue.use(NProgress)

// Enable devtools
Vue.config.devtools = true

sync(store, router)

const nprogress = new NProgress({ parent: '.nprogress-container' })

// const { state } = store
//
// router.beforeEach((route, redirect, next) => {
//   if (state.app.device.isMobile && state.app.sidebar.opened) {
//     store.commit(TOGGLE_SIDEBAR, false)
//   }
//   next()
// })

// Object.keys(filters).forEach(key => {
//   Vue.filter(key, filters[key])
// })

const app = new Vue({
  router,
  store,
  nprogress,
  ...App
})

export { app, router, store }
