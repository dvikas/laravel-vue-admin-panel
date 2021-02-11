import Vue from 'vue'
import Router from 'vue-router'
import lazyLoading from './lazyLoading'

Vue.use(Router)
// https://mattstauffer.com/blog/getting-started-using-vues-vue-router-for-single-page-apps/#router-options
export default new Router({
  // mode: 'hash',
  mode: 'history',
  linkActiveClass: 'active',
  scrollBehavior: () => ({ y: 0 }),
  routes: [
    {
      name: 'Home',
      path: '/',
      meta: {auth: true},
      component: require('../components/views/dashboard/index')
    }, {
      name: 'Login',
      path: '/login',
      meta: {auth: false},
      component: require('../components/views/auth/Login.vue')
    }, {
      path: '/login/:type',
      name: 'oauth2-type1',
      component: require('../components/views/auth/Login.vue')
    }, {
      path: '/login/auth/google',
      name: 'oauth2-type',
      component: require('../components/views/auth/Login.vue')
    }, {
      path: '/profile',
      name: 'profile',
      meta: {auth: true},
      component: require('../components/views/auth/Profile')
    }, {
      name: 'Users',
      path: '/users',
      meta: {auth: true},
      component: require('../components/views/users/index')
    }, {
      name: 'Projects',
      path: '/all-projects',
      meta: {auth: true},
      component: require('../components/views/projects/Index')
    }, {
      name: 'Clients',
      path: '/clients',
      meta: {auth: true},
      component: require('../components/views/projects/Clients')
    }, {
      name: 'AddNewProject',
      path: '/new-project',
      meta: {auth: true},
      component: require('../components/views/projects/AddNewProject')
    }, {
      name: 'ShowProject',
      path: '/projects/index/:customerId/:projectId',
      meta: {auth: true},
      component: require('../components/views/projects/AddProject')
    }, {
      name: 'ShowProject123',
      path: '/projects/1',
      meta: {auth: true},
      component: require('../components/views/projects/ShowProject')
    }, {
      name: 'Invoice',
      path: '/projects/invoice',
      meta: {auth: true},
      component: require('../components/views/projects/Invoice')
    }, {
      name: 'Typeahead',
      path: '/typeahead',
      meta: {auth: true},
      component: require('../components/views/components/Typeahead')
    }, {
      name: 'Chart',
      path: '/chart-1',
      meta: {auth: true},
      component: require('../components/views/charts/Chartjs')
    }, {
      name: 'Chart2',
      path: '/chart-2',
      meta: {auth: true},
      component: require('../components/views/charts/Chart2')
    }, {
      name: 'Calendar',
      path: '/calendar',
      meta: {auth: true},
      component: lazyLoading('Calendar')
    }, {
      name: 'Suppliers',
      path: '/suppliers',
      meta: {auth: true},
      component: require('../components/views/suppliers/index')
    }, {
      name: 'Suppliers Tasks',
      path: '/supplier-tasks',
      meta: {auth: true},
      component: require('../components/views/suppliers/tasks')
    },
    {
      path: '*',
      redirect: '/'
    }
  ]
})
