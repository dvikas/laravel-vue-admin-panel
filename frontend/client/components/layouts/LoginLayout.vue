<template>
  <!--<div class="wrapper">-->
    <!--<router-view></router-view>-->
  <!--</div>-->

  <div class="login">
    <router-view></router-view>
  </div>
</template>

<script>

  // import VAContentWrap from './partials/Content'

  export default {
    data () {
      return {
      }
    },
    created () {
    },
    components: {
      // 'va-content-wrap': VAContentWrap
    }
  }
</script>
<style lang="scss">
  @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic);
  @import "../../assets/scss/login.scss";
  div.login {
    background: url('../../assets/img/builder.jpg');
    background-color: #FFFFFF;
    background-size: 1000px;
  }
</style>
