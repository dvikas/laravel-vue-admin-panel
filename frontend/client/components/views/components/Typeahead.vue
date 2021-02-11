<template>
  <div class="vue-typeahead">
    <div class="dropdown form-group">
      <div class="input-group">
      <!-- the input field -->
      <input type="text"
             class="form-control dropdown-toggle"
             placeholder="Search twitter user"
             autocomplete="off"
             v-model="query"
             @keydown.down="down"
             @keydown.up="up"
             @keydown.enter="hit"
             @keydown.esc="reset"
             @input="update" id="dropdownMenu" data-toggle="dropdown"
             aria-haspopup="true" aria-expanded="true"/>
      <div class="input-group-addon">
        <i class="fa fa-spinner fa-spin" v-if="loading"></i>
        <template v-else>
          <i class="fa fa-search" v-show="isEmpty"></i>
          <i class="fa fa-times" v-show="isDirty" @click="reset"></i>
        </template>
      </div>
      </div>
      <!--@blur="reset"-->
      <!-- the list -->
      <ul style="display:none;" class="dropdown-menu" aria-labelledby="dropdownMenu" v-show="hasItems">
        <li v-for="(item, $item) in items" :class="activeClass($item)"
            @mousedown="hit" @mousemove="setActive($item)"><a href="#">
          <!--<span class="name" v-text="item.name"></span>-->
          <span class="screen-name" v-text="item.name"></span></a>
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
    name: 'typeahead',
    data () {
      return {
        src: 'http://builder-api.local/api/tasks',
        // (optional)The data that would be sent by request
        // data: {},
        limit: 5,
        minChars: 2,
        selectFirst: true,
        queryParamName: 'query'
      }
    },
    methods: {
      // (required)The callback function which is triggered when the user hits on an item
      onHit (item) {
        this.reset()
        this.query = 'hello'
      },

      // (optional)The callback function which is triggered when the response data are received
      prepareResponseData (data) {
        return data.data
      }
    }
  }

</script>

<style lang="scss" scoped>
  .vue-typeahead .dropdown-menu {
    display:block;
  }
  .vue-typeahead .input-group-addon .fa{
    position: inherit;
  }
</style>
