import axios from 'axios'

// initial state
const state = {
  customer: [],
  projectStatus: 0,
  projectCreatedAt: '',
  enggPlanFile: '',
  energyEffFile: '',
  archPlanFile: '',
  tab2enabled: 0,
  tab3enabled: 0,
  tab4enabled: 0,
  tab5enabled: 0,
  tab6enabled: 0,
  activeTab: 0 /* 0 is first tab  */
}

// getters
const getters = {

  getCustomerDetails (state) {
    return state.customer
  },
  getProjectStatus (state) {
    return state.projectStatus
  },
  getProjectCreatedAt (state) {
    return state.projectCreatedAt
  },
  getEnggPlanFile (state) {
    return state.enggPlanFile
  },
  getEnergyEffFile (state) {
    return state.energyEffFile
  },
  getArchPlanFile (state) {
    return state.archPlanFile
  },
  getIsTab2enabled (state) {
    return state.tab2enabled
  },
  getIsTab3enabled (state) {
    return state.tab3enabled
  },
  getIsTab4enabled (state) {
    return state.tab4enabled
  },
  getIsTab5enabled (state) {
    return state.tab5enabled
  },
  getIsTab6enabled (state) {
    return state.tab6enabled
  },
  getActiveTab (state) {
    return state.activeTab
  }
}

// actions
const actions = {
  getContactDetails ({commit}, customerId) {
    axios.get(
      process.env.API_URL + '/api/customers/' + customerId
    ).then((res) => {
      commit('setCustomer', res.data.data[0])
    })
  },
  saveContactDetails ({commit}, customer) {
    return axios({
      url: process.env.API_URL + '/api/customers',
      method: 'POST',
      data: customer
    })
  },
  updateContactDetails ({commit}, customer) {
    return axios({
      url: process.env.API_URL + '/api/customers',
      method: 'PUT',
      data: customer
    })
  }
}

// mutations
const mutations = {

  setCustomer (state, customer) {
    state.customer = customer
    state.projectStatus = customer.project_details.status
    state.archPlanFile = customer.project_details.arch_plan_file
    state.enggPlanFile = customer.project_details.engg_plan_file
    state.energyEffFile = customer.project_details.energy_eff_file
    state.projectCreatedAt = customer.project_details.created_at
    state.tab2enabled = customer.project_details.tab_2_enabled
    state.tab3enabled = customer.project_details.tab_3_enabled
    state.tab4enabled = customer.project_details.tab_4_enabled
    state.tab5enabled = customer.project_details.tab_5_enabled
    state.tab6enabled = customer.project_details.tab_6_enabled
  },
  setProjectStatus (state, status) {
    state.projectStatus = status
  },
  setEnggPlanFile (state, file) {
    state.enggPlanFile = file
  },
  setEnergyEffFile (state, file) {
    state.energyEffFile = file
  },
  setArchPlanFile (state, file) {
    state.archPlanFile = file
  },
  setIsTab2enabled (state, status) {
    state.tab2enabled = status
  },
  setIsTab3enabled (state, status) {
    state.tab3enabled = status
  },
  setIsTab4enabled (state, status) {
    state.tab4enabled = status
  },
  setIsTab5enabled (state, status) {
    state.tab5enabled = status
  },
  setIsTab6enabled (state, status) {
    state.tab6enabled = status
  },
  setActiveTab (state, index) {
    state.activeTab = index
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
