<template>
  <div class="vue-typeahead">
    <div class="dropdown form-group">
      <div class="input-group"
           :class="{'has-error': errors.has('tasksTypeahead')}">
      <!-- the input field -->
      <input type="text"
             name="tasksTypeahead"
             v-validate="'required'"
             class="form-control dropdown-toggle"
             :placeholder="taskPlaceHolder"
             autocomplete="off"
             @change="textUpdated"
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
          <i class="fa fa-times" v-show="isDirty" @click="doReset"></i>
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
        <!--<li class="disabled " @click="doCloseSuggestions"-->
            <!--v-if="!this.options.includes(this.query)"-->
            <!--style="padding:5px 0px 5px 20px;cursor: pointer"><i class="fa fa-ban"></i>&nbsp;Close Dropdown</li>-->
      </ul>
    </div>
    <!-- /TYPEAHREAD---->
    <!--<pre>{{ taskIds }}</pre>-->
<!--{{ options }}-->
  </div>
</template>

<script>
  import Vue from 'vue'
  import VueTypeahead from 'vue-typeahead'
  import VeeValidate from 'vee-validate'
  Vue.use(VeeValidate)
  export default {
    extends: VueTypeahead, // vue@1.0.22+
    name: 'tasksTypeahead',
    props: ['taskPlaceHolder', 'taskValue', 'key1', 'key2', 'parentId', 'disabled', 'doErrorClear'],
    data () {
      return {
        // src: process.env.API_URL + '/api/tasks',
        // (optional)The data that would be sent by request
        // data: {},
        limit: 5,
        minChars: 2,
        selectFirst: true,
        queryParamName: 'query',
        onHitClicked: false, // false if value typed is not in server DB
        response: {},
        options: [],
        taskIds: []
      }
    },
    computed: {
      src () {
        if (this.parentId === '-1') {
          return process.env.API_URL + '/api/tasks'
        } else {
          return process.env.API_URL + '/api/tasks/children/' + this.parentId
        }
      }
    },
    mounted () {
      this.query = this.taskValue
    },
    methods: {
      // (required)The callback function which is triggered when the user hits on an item
      onHit (item) {
        console.log('on hit called')
        this.onHitClicked = true
        this.response = {
          name: item.name,
          id: item.id,
          is_cert_required: item.is_cert_required,
          key1: this.key1,
          key2: this.key2,
          status: 'existing'
        }
        this.reset()
        console.log(this.query + '-' + item.name)
        if (this.query !== item.name) {
          this.query = item.name
        } else {
          this.textUpdated()
        }
      },

      // (optional)The callback function which is triggered when the response data are received
      prepareResponseData (data) {
        this.options = []
        this.taskIds = []
        for (let i = 0; i < data.data.length; i++) {
          this.options.push(data.data[i].name)
        }
        this.taskIds = (data.data)
        return data.data
      },
      textUpdated () {
        var returnData = ''
        if (this.onHitClicked === false) {
          let index = this.options.indexOf(this.query)
          console.log('And index is: ' + index)
          console.log('New')
          if (index === -1) {
            returnData = {
              name: this.query,
              id: null,
              key1: this.key1,
              key2: this.key2,
              status: 'new',
              is_cert_required: false
            }
          } else {
            let taskId = this.taskIds[index].id
            console.log('And TaskId is' + taskId)
            returnData = {
              name: this.query,
              id: taskId,
              is_cert_required: this.taskIds[index].is_cert_required,
              key1: this.key1,
              key2: this.key2,
              status: 'existing'
            }
          }
        } else {
          returnData = this.response
          console.log('Existing')
        }
        let tmp = this.query
        this.reset()
        this.query = tmp
        this.$emit('taskSelected', returnData)
        this.onHitClicked = false // reset
        // console.log(this.query)
      },
      doReset () {
        this.reset()
        this.textUpdated()
      }
    },
    watch: {
      taskValue (newValue) {
        this.query = newValue
      },
      parentId (newValue) {
        this.parentId = newValue
      },
      doErrorClear () {
        this.errors.clear()
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
