<template>
  <div id="app">
    <nprogress-container></nprogress-container>
    <!--<navbar :show="true"></navbar>-->
    <!--<sidebar :show="sidebar.opened && !sidebar.hidden"></sidebar>-->
    <!--<app-main></app-main>-->
    <!--<footer-bar></footer-bar>-->
    <master-layout :sidebarShow="sidebar.opened && !sidebar.hidden" v-if="$auth.check()"></master-layout>
    <login-layout v-else></login-layout>

  </div>
</template>

<script>
import NprogressContainer from 'vue-nprogress/src/NprogressContainer'
// import { Navbar, Sidebar, AppMain, FooterBar } from 'components/layout/'
import { mapGetters, mapActions } from 'vuex'
import MasterLayout from './components/layouts/MasterLayout'
import LoginLayout from './components/layouts/LoginLayout'
// import Vue from 'vue'
// import BootstrapVue from 'bootstrap-vue'
// Vue.use(BootstrapVue)

export default {
  components: {
    // Navbar,
    // Sidebar,
    // AppMain,
    // FooterBar,
    MasterLayout,
    LoginLayout,
    NprogressContainer
  },

  beforeMount () {
    const { body } = document
    const WIDTH = 768
    const RATIO = 3

    const handler = () => {
      if (!document.hidden) {
        let rect = body.getBoundingClientRect()
        let isMobile = rect.width - RATIO < WIDTH
        this.toggleDevice(isMobile ? 'mobile' : 'other')
        this.toggleSidebar({
          opened: !isMobile
        })
      }
    }

    document.addEventListener('visibilitychange', handler)
    window.addEventListener('DOMContentLoaded', handler)
    window.addEventListener('resize', handler)
  },

  computed: mapGetters({
    sidebar: 'sidebar'
  }),

  methods: mapActions([
    'toggleDevice',
    'toggleSidebar'
  ])
}
</script>
<style lang="scss">
  @import '~animate.css';
  .animated {
    animation-duration: .377s;
  }
  /*@import "./assets/scss/AdminLTE";*/

  $fa-font-path: '~font-awesome/fonts/';
  @import '~font-awesome/scss/font-awesome';

  $ionicons-font-path: '~ionicons/dist/fonts/';
  @import '~ionicons/dist/scss/ionicons';

  .nprogress-container {
    position: fixed !important;
    width: 100%;
    height: 50px;
    z-index: 2048;
    pointer-events: none;
    /*
    $color: #48e79a;
    */
    #nprogress {
      $color: #0eff00;
      /*$color: #66ccff;*/
      .bar {
        background: $color;
      }
      .peg {
        box-shadow: 0 0 10px $color, 0 0 5px $color;
      }
      .spinner-icon {
        border-top-color: $color;
        border-left-color: $color;
        display: none;
      }
    }
  }
  /*.box{*/
    /*min-height: 500px;*/
  /*}*/
</style>
