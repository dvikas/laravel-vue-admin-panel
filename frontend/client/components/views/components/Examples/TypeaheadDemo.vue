<template>
  <div class="type-ahead">
    <!--http://yuche.github.io/vue-strap/#tabs-->
    <!--https://github.com/dvikas/vue-auth/blob/ef9706cf311a18dffb47604f2954a2450dbb04ae/client/components/views/projects/partials/NewPersonalDetails.vue-->
    <!-- TYPEAHREAD---->
    <div class="Typeahead">
      <!-- optional indicators -->
      <!--<i class="fa fa-spinner fa-spin" v-if="loading"></i>-->
      <!--<template v-else>-->
        <!--<i class="fa fa-search" v-show="isEmpty"></i>-->
        <!--<i class="fa fa-times" v-show="isDirty" @click="reset"></i>-->
      <!--</template>-->

      <!-- the input field -->
      <input type="text"
             class="Typeahead__input"
             placeholder="Search twitter user"
             autocomplete="off"
             v-model="query"
             @keydown.down="down"
             @keydown.up="up"
             @keydown.enter="hit"
             @keydown.esc="reset"
             @input="update"/>
      <!--@blur="reset"-->
      <!-- the list -->
      <ul v-show="hasItems">
        <!-- for vue@1.0 use: ($item, item) -->
        <li v-for="(item, $item) in items" :class="activeClass($item)" @mousedown="hit" @mousemove="setActive($item)">

          <!--<span class="name" v-text="item.name"></span>-->
          <span class="screen-name" v-text="item.name"></span>
        </li>
      </ul>
    </div>
    <!-- /TYPEAHREAD---->

  </div>
</template>

<script>
  import VueTypeahead from 'vue-typeahead'
  export default {
    extends: VueTypeahead, // vue@1.0.22+
    name: 'myForm',
    data () {
      return {
        // The source url
        // (required)
        src: 'http://builder-api.local/api/tasks',
        // The data that would be sent by request
        // (optional)
        // data: {},

        // Limit the number of items which is shown at the list
        // (optional)
        limit: 5,

        // The minimum character length needed before triggering
        // (optional)
        minChars: 1,

        // Highlight the first item in the list
        // (optional)
        selectFirst: false,

        // Override the default value (`q`) of query parameter name
        // Use a falsy value for RESTful query
        // (optional)
        queryParamName: 'address'
      }
    },
    methods: {
      // The callback function which is triggered when the user hits on an item
      // (required)
      onHit (item) {
        this.reset()
        this.query = 'hello'
      },

      // The callback function which is triggered when the response data are received
      // (optional)
      prepareResponseData (data) {
        return data.data
      }
    }
  }

</script>

<style lang="scss" scoped>
  
</style>
