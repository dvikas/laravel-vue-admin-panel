<template>
  <aside class="main-sidebar" :class="{ slideInLeft: sidebarShow, slideOutLeft: !sidebarShow }">
    <section class="sidebar" style="height: auto;">
    <ul class="sidebar-menu tree" data-widget="tree" >
      <li class="treeview" :class="isActiveMenu(item) ? 'active menu-open':''"
          v-for="(item, index) in menu">
<!--{{ item }}-->
        <router-link :to="item.path" :exact="true" :aria-expanded="isExpanded(item) ? 'true' : 'false'" v-if="item.path" @click.native="toggle(index, item)">
          <span class="icon is-small"><i :class="['fa', item.meta.icon]"></i></span>
          {{ item.meta.label || item.name }}
          <span class="icon is-small is-angle pull-right" v-if="item.children && item.children.length">
            <i class="fa" :class="isExpanded(item)?'fa-angle-down':'fa-angle-left'"></i>
          </span>
        </router-link>
        <a href="#" :aria-expanded="isExpanded(item)" v-else @click="toggle(index, item)">
          <span class="icon is-small"><i :class="['fa', item.meta.icon]"></i></span>
          {{ item.meta.label || item.name }}
          <span class="icon is-small is-angle pull-right" v-if="item.children && item.children.length">
            <i class="fa" :class="isExpanded(item)?'fa-angle-down':'fa-angle-left'"></i>
          </span>
        </a>
        <expanding v-if="item.children && item.children.length">
          <ul class="treeview-menu" v-show="isExpanded(item)">
            <li class="treeview" v-for="subItem in item.children"  v-if="subItem.path">

              <router-link :to="generatePath(item, subItem)">
                <i :class="['fa', subItem.meta.icon]"></i>
                {{ subItem.meta && subItem.meta.label || subItem.name }}
              </router-link>
            </li>
          </ul>
        </expanding>
      </li>
    </ul>
    </section>
  </aside>

</template>

<script>
import Expanding from 'vue-bulma-expanding'
import { mapGetters, mapActions } from 'vuex'

export default {
  components: {
    Expanding
  },

  props: {
    sidebarShow: Boolean
  },

  data () {
    return {
      isReady: false
    }
  },

  mounted () {
    let route = this.$route
    if (route.name) {
      this.isReady = true
      this.shouldExpandMatchItem(route)
    }
  },

  computed: mapGetters({
    menu: 'menuitems'
  }),

  methods: {
    ...mapActions([
      'expandMenu'
    ]),

    isExpanded (item) {
      return item.meta.expanded
    },
    isActiveMenu (item) {
      let route = this.$route
      let path = item.path ? item.path : ''
      console.log(route.path + '--' + path)
      if ((typeof item.children) === 'object') {
        if (route.path === path) {
          return true
        }
        for (let i = 0; i < item.children.length; i++) {
//          console.log(item.children[i].path)
          let childPath = path === '' ? '' : path + '/'
          if (route.path === childPath + item.children[i].path) {
            return true
          }
        }
      } else {
        return route.path === path
      }
    },
    toggle (index, item) {
      this.expandMenu({
        index: index,
        expanded: !item.meta.expanded
      })
    },

    shouldExpandMatchItem (route) {
      let matched = route.matched
//      console.log(matched)
      let lastMatched = matched[matched.length - 1]
      let parent = lastMatched.parent || lastMatched
      const isParent = parent === lastMatched

      if (isParent) {
        const p = this.findParentFromMenu(route)
        if (p) {
          parent = p
        }
      }

      if ('expanded' in parent.meta && !isParent) {
        this.expandMenu({
          item: parent,
          expanded: true
        })
      }
    },

    generatePath (item, subItem) {
      return `${item.component ? item.path + '/' : ''}${subItem.path}`
    },

    findParentFromMenu (route) {
      const menu = this.menu
      for (let i = 0, l = menu.length; i < l; i++) {
        const item = menu[i]
        const k = item.children && item.children.length
        if (k) {
          for (let j = 0; j < k; j++) {
            if (item.children[j].name === route.name) {
              return item
            }
          }
        }
      }
    }
  },

  watch: {
    $route (route) {
      this.isReady = true
      this.shouldExpandMatchItem(route)
    }
  }

}
</script>
