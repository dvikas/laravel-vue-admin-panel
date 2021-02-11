import lazyLoading from './lazyLoading'

export default {
  meta: {
    label: 'UI Features',
    icon: 'fa-bar-chart-o',
    expanded: false
  },
  children: [
    {
      name: 'Chartist',
      path: '/charts/chartist',
      component: lazyLoading('charts/Chartist'),
      meta: {
        icon: 'fa-circle-o',
        link: 'charts/Chartist.vue'
      }
    },
    {
      name: 'Chartjs',
      path: '/charts/chartjs',
      component: lazyLoading('charts/Chartjs'),
      meta: {
        icon: 'fa-circle-o',
        link: 'charts/Chartjs.vue'
      }
    },
    {
      name: 'Peity',
      path: '/charts/peity',
      component: lazyLoading('charts/Peity'),
      meta: {
        icon: 'fa-circle-o',
        link: 'charts/Peity.vue'
      }
    },
    {
      name: 'Plotly',
      path: '/charts/plotly',
      component: lazyLoading('charts/Plotly'),
      meta: {
        icon: 'fa-circle-o',
        link: 'charts/Plotly.vue'
      }
    }
  ]
}
