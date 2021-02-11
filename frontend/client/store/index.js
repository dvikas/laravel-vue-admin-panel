import Vue from 'vue'
import Vuex from 'vuex'
import pkg from 'package'
import * as actions from './actions'
import * as getters from './getters'

import app from './modules/app'
// import menu from './modules/menu'
// import profile from './modules/profile'
import customerContactDetails from './modules/customerContactDetails'

Vue.use(Vuex)

const store = new Vuex.Store({
  strict: true,  // process.env.NODE_ENV !== 'production',
  actions,
  getters,
  modules: {
    app,
    // menu,
    // profile,
    customerContactDetails
  },
  state: {
    pkg,
    flashMessage: {}
  },
  mutations: {
    setFlashMessage (state, flashMessage) {
      state.flashMessage = flashMessage
    }
  }
})

export default store
