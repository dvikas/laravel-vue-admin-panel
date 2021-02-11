<template>
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
      <!-- Sidebar user panel -->
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">-->
        <!--<div class="input-group">-->
          <!--<input name="q" class="form-control" placeholder="Search..." type="text">-->
          <!--<span class="input-group-btn">-->
                <!--<button type="submit" name="search" id="search-btn" class="btn btn-flat">-->
                  <!--<i class="fa fa-search"></i>-->
                <!--</button>-->
              <!--</span>-->
        <!--</div>-->
      <!--</form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <router-link exact tag="li" :to="{ path: '/'}">
          <a href="#"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
        </router-link>

        <li class="header">PROJECTS</li>

        <router-link exact tag="li" :to="{ path: '/all-projects', query: { page: '1' }}">
          <a href="#"><i class="fa fa-home"></i><span>All projects</span></a>
        </router-link>

        <router-link exact tag="li" :to="{ path: '/new-project'}">
          <a href="#"><i class="fa fa-plus-square"></i><span>Add new project</span></a>
        </router-link>

        <!--<router-link exact tag="li" :to="{ path: '/projects'}">-->
          <!--<a href="#"><i class="fa fa-address-book-o"></i><span>All customers</span></a>-->
        <!--</router-link>-->


        <li class="header">SUPPLIERS</li>

        <router-link tag="li" :to="{ path: '/suppliers'}">
          <a href="#"><i class="fa fa-truck"></i><span>All suppliers</span></a>
        </router-link>

        <router-link tag="li" :to="{ path: '/supplier-tasks'}">
          <a href="#"><i class="fa fa-tasks"></i><span>Supplier tasks</span></a>
        </router-link>

        <li class="header">USERS</li>

        <router-link tag="li" :to="{ path: '/users'}">
          <a href="#"><i class="fa fa-users"></i><span>All users</span></a>
        </router-link>

        <!--<router-link exact tag="li" :to="{ path: '/projects/invoice'}">-->
          <!--<a href="#"><i class="fa fa-book"></i><span>Invoice</span></a>-->
        <!--</router-link>-->
        <!--<router-link exact tag="li" :to="{ path: '/chart-1'}">-->
          <!--<a href="#"><i class="fa fa-book"></i><span>Chart 1</span></a>-->
        <!--</router-link>-->
        <!--<router-link exact tag="li" :to="{ path: '/chart-2'}">-->
          <!--<a href="#"><i class="fa fa-book"></i><span>Chart 2</span></a>-->
        <!--</router-link>-->


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
export default {

}
</script>
