<template>
  <div class="vue-typeahead">
    <div class="dropdown form-group">
      <div class="input-group"
           :class="{'has-error': errors.has('tasksTypeahead')}">
      <!-- the input field -->
      <input type="text"
             name="tasksTypeahead"
             class="form-control dropdown-toggle"
             placeholder="Select Template"
             autocomplete="off"
             v-model="query"
             @keydown.down="down"
             @keydown.up="up"
             @keydown.enter="hit"
             @keydown.esc="reset"
             @input="update" data-toggle="dropdown"
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
      <ul style="display:none;" class="dropdown-menu" aria-labelledby="dropdownMenu1" v-show="hasItems">
        <li v-for="(item, $item) in items" :class="activeClass($item)"
            @mousedown="hit" @mousemove="setActive($item)"><a href="#">
          <!--<span class="name" v-text="item.name"></span>-->
          <span class="screen-name" v-text="item.name"></span></a>
        </li>
      </ul>
    </div>
    <!-- /TYPEAHREAD---->
<!--{{ onHitClicked }}-->
  </div>
</template>

<script>
  import Vue from 'vue'
  import VueTypeahead from 'vue-typeahead'
  import VeeValidate from 'vee-validate'
  Vue.use(VeeValidate)
  export default {
    extends: VueTypeahead, // vue@1.0.22+
    name: 'draft-tyepahead',
    props: ['customerId', 'projectId'],
    data () {
      return {
        limit: 5,
        minChars: 2,
        selectFirst: true,
        queryParamName: 'query',
        response: {}
      }
    },
    computed: {
      src () {
        return process.env.API_URL + '/api/users/draft-tasks'
      }
    },
    mounted () {
    },
    methods: {
      // (required)The callback function which is triggered when the user hits on an item
      onHit (item) {
        console.log('on hit called')
        this.reset()
        this.query = item.name
        this.fetchTemplate(item.id)
      },

      // (optional)The callback function which is triggered when the response data are received
      prepareResponseData (data) {
        return data.data
      },

      fetchTemplate (draftId) {
        this.$http({
          url: process.env.API_URL + '/api/users/draft-tasks/' + draftId + '/' + this.customerId + '/' + this.projectId,
          method: 'GET'
        }).then((res) => {
          this.$emit('draftSelected', res.data)
        })
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
