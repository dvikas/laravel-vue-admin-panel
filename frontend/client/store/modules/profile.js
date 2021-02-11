const state = {
  profile: []
}

// getters
const getters = {
  getProfile (state) {
    return state.profile
  }
}

// actions
const actions = {
  addNewSubTask ({ commit }) {
  }
}

// mutations
const mutations = {
  setProfile (state, data) {
    state.profile = data
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
