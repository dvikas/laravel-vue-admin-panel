<template>
  <div :class="sidebarShow ? 'sidebar-open':''">
    <div class="wrapper">
      <va-navibar></va-navibar>
      <va-sidebar ></va-sidebar>
      <code class="hidden">{{ flashMessage }}</code>
      <va-content-wrap></va-content-wrap>

      <!-- Main Footer -->
      <footer class="main-footer">
        <div class="container ">
          <div class="pull-right" style="margin-right:100px;">
            <strong>Copyright &copy; 2018
              <a href="javascript:;">All Reno</a>.</strong> All rights reserved.
          </div>
        </div>
      </footer>

    </div>
  </div>
</template>

<script>
  import Vue from 'vue'
  import VANaviBar from './partials/NaviBar'
  import VASideBar from '../layouts/partials/SideBar'
  import VAContentWrap from './partials/Content'
  import Notification from 'vue-bulma-notification'
  const NotificationComponent = Vue.extend(Notification)

  const openNotification = (propsData = {
    title: '',
    message: '',
    type: '',
    direction: '',
    duration: 4500,
    container: '.notifications'
  }) => {
    return new NotificationComponent({
      el: document.createElement('div'),
      propsData
    })
  }
  export default {
    name: 'app',
    props: {
      sidebarShow: Boolean
    },
    components: {
      'Notification': Notification,
      'va-navibar': VANaviBar,
      'va-sidebar': VASideBar,
      'va-content-wrap': VAContentWrap
      // Modal
    },
    computed: {
      flashMessage () {
        if (this.$store.getters.getFlashMessage.message !== undefined) {
          this.openNotificationWithType(this.$store.getters.getFlashMessage)
        }
      }
    },
    data () {
      return {
      }
    },
    created () {
    },
    mounted () {
    },
    methods: {
      openNotificationWithType (obj) {
        openNotification({
          title: obj.title,
          message: obj.message,
          type: obj.type
        })
      }
    }
    // store
  }
</script>
<style lang="scss">

  @import "../../assets/scss/AdminLTE";

  html {
    background-color: whitesmoke;
  }
  .content-wrapper {
    min-height: 600px;
    padding-bottom: 100px;
  }
</style>
