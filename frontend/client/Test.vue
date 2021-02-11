<template>
  <div class="tasks-subtasks">
    <draggable v-model="items" :options="{handle:'.parent-handle'}" @start="drag=true" @end="drag=false">
      <div class="box box-info box-solid" v-for="(citems, key1, index) in items" :key="index">

        <div class="box-header" >
          <div class="row" >
            <div class="col-sm-1 parent-handle" title="Move Parent Task">
              <i class="fa fa-arrows-alt text-info"></i>
            </div>

            <div class="col-sm-3 " >
              <div class="input-group">
                <input type="text" v-model="citems.parent" class="form-control parent-task" name="parent_task"
                       placeholder="Parent Task"  />
              </div>
            </div>
            <div class="col-sm-2 ">
              <datepicker v-model="citems.start_date" :clear-button="clear"
                          :icons-font="font" :format="format"    :placeholder="dateStartPlaceholder"></datepicker>
            </div>
            <div class="col-sm-2 ">
              <datepicker v-model="citems.end_date" :clear-button="clear" :format="format" :icons-font="font"  :placeholder="dateEndPlaceholder" ></datepicker>
            </div>
            <div class="col-sm-2 ">
              <div class="input-group">
                <select v-model="citems.milestone" class="form-control" >
                  <option selected value="">Select Milestone</option>
                  <option value="Milestone 1">Milestone 1</option>
                  <option value="Milestone 2">Milestone 2</option>
                  <option value="Milestone 3">Milestone 3</option>
                  <option value="Milestone 4">Milestone 4</option>
                  <option value="Milestone 5">Milestone 5</option>
                </select>
              </div>

            </div>
            <div class="col-sm-2 ">
              <div class="input-group">
                <input type="text" class="form-control" v-model="citems.amount" placeholder="Amount">
                <div class="input-group-addon " @click="showModal(key1)"><i class="fa fa-pencil text-success"></i></div>
              </div>

            </div>

          </div>

          <div class="row" v-if="citems.notes" >
            <div class="col-sm-11 col-sm-offset-1">
              <p class="notes" >
                <i class="fa fa-quote-left"></i>&nbsp;{{ citems.notes }}&nbsp;<i class="fa fa-quote-right"></i>
              </p>
            </div>
          </div>

        </div>
        <div class="box-body subtasks sub-tasks-box">
          <div class="row sub-task-header">
            <div class="col-sm-1">
              &nbsp;
            </div>
            <div class="col-sm-10">
              <div class="row hidden-xs" >
                <div class="col-sm-4 " >
                  <label>Sub Task</label>
                </div>
                <div class="col-sm-2 " >
                  <label>Quantity</label>
                </div>
                <div class="col-sm-2" >
                  <label>Unit</label>
                </div>
                <div class="col-sm-2">
                  <label>Rate($)</label>
                </div>
                <div class="col-sm-2" >
                  <label>Total($)</label>
                </div>
              </div>
            </div>
            <div class="col-sm-1">
              &nbsp;
            </div>
          </div>
          <draggable :list="citems.child" :options="dragOptions(key1)" :move="onMove" @start="isDragging=true" @end="isDragging=false">
            <transition-group name="list-complete">
              <div class="list-complete-item" v-for="(citem, key2, cindex) in citems.child" v-bind:key="key2">

                <div class="row sub-task-row" style="transition: all 1s ease 1s;">
                  <div class="col-sm-1 handle" title="Move">
                    <i class="fa fa-arrows-alt text-info"></i>
                  </div>
                  <div class="col-sm-10">
                    <div  >
                      <form >
                        <div class="row">

                          <div class="col-sm-4">
                            <div class="form-group" :class="{'has-error': errors.has('sub_task_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.sub_task"
                                     placeholder="Subtask" v-bind:name="'sub_task_'+key1+key2" v-validate="'required'"/>
                            </div>
                          </div>

                          <div class="col-sm-2 ">
                            <div class="form-group"  :class="{'has-error': errors.has('quantity_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.quantity" maxlength="5"
                                     placeholder="Quantity" v-bind:name="'quantity_'+key1+key2" v-validate="'required|numeric'">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group" :class="{'has-error': errors.has('unit_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.unit"
                                     placeholder="Unit" v-bind:name="'unit_'+key1+key2" v-validate="'required'">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group" :class="{'has-error': errors.has('rate_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.rate" maxlength="10"
                                     placeholder="Rate" v-bind:name="'rate_'+key1+key2" v-validate="'required|decimal'">
                            </div>
                          </div>
                          <div class="col-sm-2" >
                            <div class="form-group" :class="{'has-error': errors.has('total_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.total" maxlength="10"
                                     placeholder="Total" v-bind:name="'total_'+key1+key2" v-validate="'required|decimal'">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label ><input type="checkbox"> Is Certificate required</label>
                            </div>
                          </div>
                        </div>

                      </form>
                    </div>
                  </div>
                  <div class="col-sm-1">
                    <button @click="deleteRow(key1, key2)" title="Delete subtask" class="btn btn-link" type="button">
                      <i class="fa fa-trash-o text-maroon"></i></button>
                  </div>
                </div>

              </div>
            </transition-group>
          </draggable>
        </div><!--.box-body-->
        <div class="box-footer subtasks" slot="footer">

          <div class="row sub-task-row">
            <div class="col-sm-1">
              &nbsp;
            </div>
            <div class="col-sm-10">
              <div  >
                <form >
                  <div class="row">

                    <div class="col-sm-4">
                      <div class="form-group"  :class="{'has-error': errors.has('sub_task_new_'+key1)}">
                        <typeahead :data="USstate" class="form-control1"  v-model="citems.new.sub_task"
                                   placeholder="Subtask" v-bind:name="'sub_task_new_'+key1" v-validate="'required'">
                        </typeahead>
                        <!--<input type="text" class="form-control"-->
                        <!--placeholder="Subtask" v-model="citems.new.sub_task" />-->
                      </div>
                    </div>

                    <div class="col-sm-2 ">
                      <div class="form-group" :class="{'has-error': errors.has('quantity_new_'+key1)}">
                        <input type="text" class="form-control" v-model="citems.new.quantity" maxlength="5"
                               placeholder="Quantity"  v-bind:name="'quantity_new_'+key1"
                               v-validate="'required|numeric'"  />
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group"  :class="{'has-error': errors.has('unit_new_'+key1)}">
                        <input type="text" class="form-control" v-model="citems.new.unit"
                               placeholder="Unit"  v-bind:name="'unit_new_'+key1" v-validate="'required'"/>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group"  :class="{'has-error': errors.has('rate_new_'+key1)}">
                        <input type="text" class="form-control" v-model="citems.new.rate"  maxlength="10"
                               placeholder="Rate" v-bind:name="'rate_new_'+key1" v-validate="'required|decimal'" />
                      </div>
                    </div>
                    <div class="col-sm-2" >
                      <div class="form-group"  :class="{'has-error': errors.has('total_new_'+key1)}">
                        <input type="text" class="form-control" v-model="citems.new.total"
                               placeholder="Total" v-bind:name="'total_new_'+key1" v-validate="'required|decimal'" />
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label ><input type="checkbox"> Is Certificate required</label>
                      </div>
                    </div>
                  </div>

                </form>
              </div>
            </div>
            <div class="col-sm-1">
              <button title="Add subtask" @click="addRow(citems.new, key1)" type="button" class="btn btn-success btn-sm">Add</button>
            </div>
          </div>

        </div>
      </div><!--.box-->
    </draggable>

    <modal v-model="manageMilestoneNotes" effect="fade">
      <div slot="modal-header" class="modal-header">
        <h4 class="modal-title">
          <b>Notes</b>
        </h4>
      </div>
      <div slot="modal-body" class="modal-body">

        <textarea class="form-control" v-model="notes" placeholder="Add Notes" ></textarea>
      </div>

      <!-- custom buttons -->
      <div slot="modal-footer" class="modal-footer">
        <button type="button" class="btn btn-default" @click="manageMilestoneNotes = false">Cancel</button>
        <button type="button" @click="saveNotes" class="btn btn-primary" >Save</button>
      </div>
    </modal>

    <pre>{{ errors }}</pre>
    <pre>{{ items }}</pre>
  </div>
</template>

<script>
  // var newElem = {sub_task: '', quantity: '', unit: '', rate: '', total: ''}
  // var obj = [
  //   {
  //     parent: '',
  //     start_date: '',
  //     end_date: '',
  //     milestone: '',
  //     amount: '',
  //     notes: '',
  //     child: [],
  //     new: newElem
  //   }
  // ]
  // var obj = [
  //   {
  //     parent: 'vikas',
  //     start_date: '',
  //     end_date: '',
  //     milestone: '',
  //     amount: '',
  //     notes: '',
  //     child: [
  //       {name: 'Peter', sub_task: 'blank1', quantity: 34, unit: 23, rate: '', total: ''},
  //       {name: 'Andrew', sub_task: 'blank2', quantity: 24, unit: 28, rate: '', total: ''},
  //       {name: 'Raja', sub_task: 'blank3', quantity: 44, unit: 98, rate: '', total: ''}
  //     ],
  //     new: newElem
  //   },
  //   {
  //     parent: 'vikas1',
  //     start_date: '',
  //     end_date: '',
  //     amount: '',
  //     notes: '',
  //     child: [
  //       { name: 'Peter1', sub_task: 'blank4', quantity: 57, unit: 23, rate: '', total: '' },
  //       { name: 'Andrew1', sub_task: 'blank5', quantity: 34, unit: 28, rate: '', total: '' },
  //       { name: 'Raja1', sub_task: 'blank6', quantity: 67, unit: 98, rate: '', total: '' }
  //     ],
  //     new: newElem
  //   }
  // ]

  import { typeahead, modal, datepicker } from 'vue-strap'
  import Vue from 'vue'
  import VeeValidate from 'vee-validate'
  Vue.use(VeeValidate)
  import draggable from 'vuedraggable'
  //  import subTaskForm from './subTaskForm'

  export default {
    name: 'ClientQuoting',
    components: {
      typeahead, draggable, modal, datepicker
    },
    data () {
      return {
        USstate: ['Alabama', 'Alaska', 'United'],
//        githubTemplate: 'Hello',
//        asyncTemplate: '<span >{{ item.text }}</span>',
//         items: {},
//         items: obj,
        isDragging: false,
        delayedDragging: false,
        // Date Picker
        dateEndPlaceholder: 'Select end date',
        dateStartPlaceholder: 'Select start date',
        format: 'MMM-dd-yyyy',
        clear: true,
        font: 'fa',
        // Modal
        manageMilestoneNotes: false,
        currentMilestoneKey: '',
        notes: ''
      }
    },
    computed: {
      items () {
        return this.$store.getters.getItemsJson
      }
    },
    methods: {
      showModal (key) {
        this.manageMilestoneNotes = true
        this.currentMilestoneKey = key
        var notes = this.items[this.currentMilestoneKey].notes
        this.notes = notes
      },
      saveNotes () {
        this.items[this.currentMilestoneKey].notes = this.notes
        this.manageMilestoneNotes = false
        this.notes = ''
      },
      dragOptions (key) {
        return {
//          animation: 1,
          group: 'description' + key,
//          disabled: !this.editable,
//          ghostClass: 'ghost',
          handle: '.handle'
        }
      },
      deleteRow (key1, key2) {
        this.items[key1].child.splice(key2, 1)
      },
      addRow (data, key) {
        this.$validator.validateAll().then((result) => {
          if (result) {
            /*******************************/
            // var customerId = this.$route.params.id

            // var dataJson = {
            //   'customer_id': customerId,
            //   'parent_task': this.items[key].parent,
            //   'child_task': data.sub_task,
            //   'quantity': data.quantity,
            //   'unit': data.unit,
            //   'rate': data.rate,
            //   'total': data.total,
            //   'certificate_id': null
            // }
            this.sub_task = ''
            this.quantity = ''
            this.unit = ''
            this.rate = ''
            this.total = ''
            // this.$http({
            //   url: process.env.API_URL + '/api/customers/tasks',
            //   method: 'POST',
            //   data: dataJson
            // })
            //   .then((res) => {
            //     this.errors.clear()
            //   }, (res) => {
            //   })
            this.errors.clear()
            /*******************************/
            // this.items[key].child = []
            // this.items[key].child.push({
            //   sub_task: data.sub_task,
            //   quantity: data.quantity,
            //   unit: data.unit,
            //   rate: data.rate,
            //   total: data.total
            // })
            //
            // this.items[key].new.sub_task = ''
            // this.items[key].new.quantity = ''
            // this.items[key].new.unit = ''
            // this.items[key].new.rate = ''
            // this.items[key].new.total = ''

            this.$store.dispatch('addNewSubTask', { data, key })
          }
        })
      },
      getTypeaheadData () {
        console.log('getting')
      },
      githubCallback (item) {
        console.log(item)
      },
      googleCallback (item) {
        return item.value
      },
      handleChange () {
        console.log('changed')
      },
      inputChanged (value) {
        this.activeNames = value
      },
      getComponentData () {
        return {
          on: {
            change: this.handleChange,
            input: this.inputChanged
          },
          props: {
            value: this.activeNames
          }
        }
      },
      onMove ({relatedContext, draggedContext}) {
        const relatedElement = relatedContext.element
        const draggedElement = draggedContext.element
        return (!relatedElement || !relatedElement.fixed) && !draggedElement.fixed
      }
    },
    watch: {
      // itemsJson: function () {
      //   this.items = this.itemsJson
      // },
      // isDragging (newValue) {
      //   if (newValue) {
      //     this.delayedDragging = true
      //     return
      //   }
      //   this.$nextTick(() => {
      //     this.delayedDragging = false
      //   })
      // }
    }
  }
</script>

<style lang="scss" scoped>
  p.notes{
    margin-bottom: 0;margin-top:5px;
  }
</style>
