<template>

  <div class="tasks-subtasks">

    <div class="container">
      <div class="row">
        <div class="col-sm-2 col-sm-offset-9 text-right">
          <h4>Client Quote:</h4>
        </div>
        <div class="col-sm-1 text-right">
          <h4>${{quoteTotal}}</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2 col-sm-offset-9 text-right">
          <h4>Variations:</h4>
        </div>
        <div class="col-sm-1 text-right">
          <h4>${{variationTotal}}</h4>
        </div>
      </div>
      <div class="row " >
        <div class="col-sm-2 col-sm-offset-9 text-right " style="border-top:1px solid">
          <h4>Total:</h4>
        </div>
        <div class="col-sm-1 text-right text-success" style="border-top:1px solid">
          <h4>${{grandTotal}}</h4>
        </div>

      </div>
    </div>


    <!--<supplier-project-tasks :customer-id="customerId" :project-id="projectId"></supplier-project-tasks>-->

    <draggable :list="items"  :options="{handle:'.parent-handle'}" @start="isDragging=true"
               :component-data="getParentComponentData()" @end="isDragging=false" :move="onMove">
      <div class="box box-info box-solid" v-for="(citems, key1, index) in items" :key="index">

        <div class="box-header" >
          <div class="row" >
            <!--<div class="col-sm-1 parent-handle" title="Move Parent Task">-->
              <!--<i class="fa fa-arrows-alt text-info"></i>-->
            <!--</div>-->
            <div class="col-sm-1">&nbsp;</div>

            <div class="col-sm-10 ">
              <div class="row hidden-xs" >
                <div class="col-sm-4 ">
                  <div class="form-group" >
                    <input class="form-control" v-model="citems.parent" disabled>
                  </div>
                </div>

                <div class="col-sm-2 ">

                  <div class="form-group"
                       :class="{'has-error': errors.has('tasks.start_date'+key1)}">
                    <input type="date" lang="en" name="start_date" data-name="start_date" :data-key="key1" :key="key1"
                           class="form-control" v-model="citems.start_date" v-bind:name="'start_date'+key1"
                           disabled
                           v-validate="'required'"  data-vv-scope="tasks">
                  </div>
                </div>
                <div class="col-sm-2 ">
                  <div class="form-group"
                       :class="{'has-error': errors.has('tasks.end_date'+key1)}">
                    <input type="date" name="end_date" :key="key1" data-name="end_date" :data-key="key1"
                           class="form-control" v-model="citems.end_date" v-bind:name="'end_date'+key1"
                           v-validate="'required'"  data-vv-scope="tasks" disabled >
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="form-group"
                       :class="{'has-error': errors.has('tasks.milestone'+key1)}">
                    <input type="text" name="milestone" :key="key1" data-name="label" :data-key="key1"
                            class="form-control" v-model="citems.milestone" v-bind:name="'milestone'+key1"
                           disabled
                           placeholder="Milestone" v-validate="'required'"  data-vv-scope="tasks" >
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="input-group"
                       :class="{'has-error': errors.has('tasks.amount'+key1)}">
                    <input type="text" class="form-control" data-name="amount" :data-key="key1"
                           name="amount" :key="key1" v-model="citems.amount" placeholder="Amount"
                           v-bind:name="'amount'+key1" v-validate="'required|min_value:1'"
                           data-vv-scope="tasks" disabled >

                    <!--<div v-if="citems.child.length === 0" class="input-group-addon">-->
                      <!--<i class="fa fa-pencil text-success"></i></div>-->
                    <!--<div v-else class="input-group-addon"-->
                         <!--@click="showModal(key1)"><i class="fa fa-pencil text-success"></i></div>-->

                  </div>

                </div>
              </div>
            </div>
            <div class="col-sm-1">
              <!--<button @click="deleteParent(key1)" title="Delete Parent Task" class="btn btn-danger" type="button">-->
                <!--<i class="fa fa-trash-o"></i></button>-->
            </div>
          </div>

          <div class="row"  >

            <div class="col-sm-10 col-sm-offset-1">
              <p class="notes" v-if="citems.notes">
                &nbsp;{{ citems.notes }}
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
          <draggable :list="citems.child" :options="dragOptions(key1)" :move="onMove" @start="isDragging=true"
                     @end="updateTaskPosition" :data-key="key1" :component-data="getComponentData()">
            <transition-group :name="'list-complete'+key1">
              <div class="list-complete-item" v-for="(citem, key2, cindex) in citems.child"
                   v-if="parseInt(citem.is_locked) !== 1" v-bind:key="key2">

                <div class="row sub-task-row" style="transition: all 1s ease 1s;">
                  <!--<div class="col-sm-1 handle" title="Move">-->
                    <!--<i class="fa fa-arrows-alt text-info"></i>-->
                  <!--</div>-->
                  <div class="col-sm-1">&nbsp;</div>
                  <div class="col-sm-10">
                    <div  >
                      <form >
                        <div class="row">

                          <div class="col-sm-4">
                            <div class="form-group">
                              <tasks-typeahead  @taskSelected="updateSubTaskValue" :key1="key1" :key2="key2"
                                                taskPlaceHolder="Search Child Tasks"
                                                :taskValue="citem.sub_task"
                                                :parentId="citems.parent_id">
                              </tasks-typeahead>
                              <!--<input type="text" class="form-control" v-model="citem.sub_task"-->
                                     <!--placeholder="Subtask" v-bind:name="'sub_task_'+key1+key2" v-validate="'required'"/>-->
                            </div>
                          </div>

                          <div class="col-sm-2 ">
                            <div class="form-group"  :class="{'has-error': errors.has('tasks.quantity_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.quantity" maxlength="5"
                                     placeholder="Quantity" v-bind:name="'quantity_'+key1+key2"
                                     data-name="quantity" :data-key1="key1" :data-key2="key2"
                                     data-vv-scope="tasks"
                                     v-validate="'required|numeric'">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group" :class="{'has-error': errors.has('tasks.unit_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.unit"
                                     placeholder="Unit" v-bind:name="'unit_'+key1+key2"
                                     data-name="unit" :data-key1="key1" :data-key2="key2"
                                     data-vv-scope="tasks"
                                     v-validate="'required'">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group" :class="{'has-error': errors.has('tasks.rate_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.rate" maxlength="10"
                                     placeholder="Rate" v-bind:name="'rate_'+key1+key2"
                                     data-name="rate" :data-key1="key1" :data-key2="key2"
                                     data-vv-scope="tasks"
                                     v-validate="'required|decimal'">
                            </div>
                          </div>
                          <div class="col-sm-2" >
                            <div class="form-group" :class="{'has-error': errors.has('tasks.total_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.total" maxlength="10"
                                     placeholder="Total" v-bind:name="'total_'+key1+key2"
                                     data-name="total" :data-key1="key1" :data-key2="key2"
                                     data-vv-scope="tasks"
                                     v-validate="'required|decimal'">
                            </div>
                          </div>
                        </div>

                        <div class="row" v-if="citem.is_cert_required === true">
                          <div class="col-sm-6 form-inline">
                            <div class="form-group" :class="{'has-error': citem.certificate_path === ''}">
                              <label >Upload Certificate:</label>
                            </div>
                            <div class="form-group" >
                              <image-upload :file-name="citem.customer_sub_task_id"
                                            category="customer_sub_task" :key1="key1" :key2="key2"
                                            @fileLoaded="afterImageLoaded"></image-upload>
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
                      <div class="form-group"  :class="{'has-error': citems.newChild.hasEmptySubTask === 1}">
                        <tasks-typeahead  @taskSelected="updateNewTaskValue" :key1="key1" key2=""
                                          taskPlaceHolder="Search Child Tasks"
                                          :taskValue="citems.newChild.sub_task"
                                          :parentId="citems.parent_id">
                        </tasks-typeahead>
                      </div>
                    </div>

                    <div class="col-sm-2 ">
                      <div class="form-group"
                           :class="{'has-error': errors.has('new_child_'+key1+'.quantity_new_'+key1)}">
                        <input type="text" class="form-control" v-model="citems.newChild.quantity" maxlength="5"
                               placeholder="Quantity"  v-bind:name="'quantity_new_'+key1"
                               v-validate="'required|numeric'"  :data-vv-scope="'new_child_'+key1" />
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group"
                           :class="{'has-error': errors.has('new_child_'+key1+'.unit_new_'+key1)}">
                        <input type="text" class="form-control" v-model="citems.newChild.unit"
                               :data-vv-scope="'new_child_'+key1"
                               placeholder="Unit"  v-bind:name="'unit_new_'+key1" v-validate="'required'"/>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group"
                           :class="{'has-error': errors.has('new_child_'+key1+'.rate_new_'+key1)}">
                        <input type="text" class="form-control" v-model="citems.newChild.rate"
                               :data-vv-scope="'new_child_'+key1" maxlength="10"
                               placeholder="Rate" v-bind:name="'rate_new_'+key1" v-validate="'required|decimal'" />
                      </div>
                    </div>
                    <div class="col-sm-2" >
                      <div class="form-group"
                           :class="{'has-error': errors.has('new_child_'+key1+'.total_new_'+key1)}">
                        <input type="text" class="form-control" v-model="citems.newChild.total"
                               :data-vv-scope="'new_child_'+key1"
                               placeholder="Total" v-bind:name="'total_new_'+key1" v-validate="'required|decimal'" />
                      </div>
                    </div>
                  </div>

                  <div class="row" v-if="citems.newChild.status === 'new'">
                    <div class="col-sm-6 form-inline">
                      <div class="form-group">
                        <label ><input type="checkbox" v-model="citems.newChild.is_cert_required"> Is Certificate required?</label>
                      </div>
                      <div class="form-group"  :class="{'has-error': citems.newChild.certificate_path === ''}"
                           v-if="citems.newChild.is_cert_required === true">
                        <image-upload file-name="new_file" category="new_file"
                                      :key1="key1" key2="-1" @fileLoaded="afterImageLoaded"></image-upload>
                      </div>
                    </div>
                  </div>

                  <div v-else>
                    <div class="row" v-if="citems.newChild.is_cert_required === true">
                      <div class="col-sm-6 form-inline">
                        <div class="form-group"  :class="{'has-error': citems.newChild.certificate_path === ''}">
                          <label > Upload Certificate</label>
                        </div>
                        <div class="form-group" >
                          <image-upload file-name="new_file" category="new_file"
                                        :key1="key1" key2="-1" @fileLoaded="afterImageLoaded"></image-upload>
                        </div>
                      </div>
                    </div>
                  </div>

                </form>
              </div>
            </div>
            <div class="col-sm-1">
              <button title="Add subtask" @click="addRow(citems.newChild, key1)" type="button" class="btn btn-success btn-sm">Add</button>
            </div>
          </div>

        </div>
      </div><!--.box-->
    </draggable>


    <!--<div class="row">-->
      <!--<div class="col-sm-12">-->
        <!--<button type="button" @click="addNewTaskJson" class="btn btn-info">Add new Task</button>-->
      <!--</div>-->
    <!--</div>-->
    <div class="row " v-if="errorOnPage === true">
      <div class="col-sm-12 text-right">
        <p class="text-danger">
          Please fix the errors on page.
        </p>
        <p class="text-danger" v-for="error in errorMsgOnPage" v-text="error">
        </p>
      </div>

    </div>
    <!--<div class="row mt-50 ">-->
      <!--<div class="col-sm-6 form-inline">-->
        <!--<div class="form-group " :class="{'has-error': errors.has('draft.draftName')}">-->
          <!--<input v-model="draftName" v-validate="'required'" class="form-control"-->
                 <!--data-vv-scope="draft" name="draftName" placeholder="Template name">-->
          <!--<button type="button" @click="saveTaskAsDraft" class="btn btn-default">Save</button>-->
        <!--</div>-->
      <!--</div>-->
      <!--<div class="col-sm-6 form-inline text-right">-->

        <!--<a type="button " v-if="errorOnPage === false && pageValidated === true"-->
           <!--:href="serverName + '/invoice/' + customerId + '/' + $auth.user().id"-->
           <!--class="btn btn-twitter"> <i class="fa fa-file-pdf-o"></i> View Invoice</a>-->
        <!--<button type="button " @click="validatePage" class="btn btn-success">Save Details</button>-->

      <!--</div>-->
    <!--</div>-->

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

    <!--<pre>{{ errors.has('sub_task_new_0') }}</pre>-->
    <!--<pre>customerId : {{ customerId }}</pre>-->
    <!--<pre>ProjectId : {{ projectId }}</pre>-->
    <!--<pre>{{ errors }}</pre>-->
    <!--<pre>{{ items }}</pre>-->

  </div>
</template>

<script>

  var newObj = [
    {
      parent: '',
      parent_id: 0,
      milestone_id: '',
      start_date: '',
      end_date: '',
      milestone: '',
      amount: '',
      notes: '',
      child: [],
      newChild: {
        sub_task: '',
        sub_task_id: 0,
        customer_sub_task_id: 0,
        quantity: '',
        unit: '',
        rate: '',
        total: '',
        is_cert_required: false,
        certificate_path: ''
      }
    }
  ]
  var obj = []
  import DraftTyepahead from '../DraftTypeahead'
  import TasksTypeahead from './TasksTypeahead'
  import { typeahead, modal, datepicker } from 'vue-strap'
  import Vue from 'vue'
  import VeeValidate from 'vee-validate'
  import draggable from 'vuedraggable'
  import ImageUpload from './ImageUpload'
  import SupplierProjectTasks from './client-quoting/SupplierProjectTasks'

  Vue.use(VeeValidate)

  export default {
    name: 'project-variations',
    components: {
      SupplierProjectTasks,
      DraftTyepahead,
      TasksTypeahead,
      typeahead,
      draggable,
      modal,
      datepicker,
      ImageUpload
    },
    data () {
      return {
        parentTasksArray: [],
        items: obj,
        isDragging: false,
        delayedDragging: false,
        // Modal
        manageMilestoneNotes: false,
        currentMilestoneKey: '',
        notes: '',
        grandTotal: 0,
        quoteTotal: 0,
        variationTotal: 0,
        draftName: '',
        customerId: this.$route.params.customerId,
        projectId: this.$route.params.projectId,
        serverName: process.env.API_URL,
        errorOnPage: false,
        errorMsgOnPage: [],
        pageValidated: false
      }
    },

    computed: {
      activeTab () {
        return this.$store.getters.getActiveTab
      }
    },

    created () {
//      this.setTasks()
    },

    methods: {

      afterImageLoaded (imageData) {
        let fileName = imageData.fileName
        let file = imageData.file
        let category = imageData.category
        let key1 = imageData.key1
        let key2 = imageData.key2
        let data = new window.FormData()
        data.append('avatar', file)
        data.append('field_name', fileName)
        data.append('category', category)
        data.append('customerId', this.customerId)
        data.append('projectId', this.projectId)
        this.$http({
          url: process.env.API_URL + '/api/assets',
          method: 'POST',
          data: data
        }).then((res) => {
          console.log(res.data.field)
          console.log(res.data.path)
          if (category === 'customer_sub_task') {
            this.items[key1].child[key2].certificate_path = res.data.path
          } else if (category === 'new_file') {
            this.items[key1].newChild.certificate_path = res.data.path
          }
        })
      },

      getTotalAmount () {
        let totalAmount = 0
        this.items.forEach((item, i) => {
          if (item.parent === '') {
            this.errorOnPage = true
          }

          totalAmount += parseFloat(item.amount)

          item.child.forEach((childTask, j) => {
            if (childTask.sub_task === '') {
              this.errorOnPage = true
            }
          })
        })
        return totalAmount.toFixed(2)
      },

      addNewTaskJson () {
        var mObj = JSON.parse(JSON.stringify(newObj))
        this.items.push(...mObj)
        console.log(this.items)
      },

      setGrandTotalAmount () {
        let total = 0
        let quoteTotal = 0
        let variationTotal = 0
        for (let i = 0; i < this.items.length; i++) {
          for (let j = 0; j < this.items[i].child.length; j++) {
            if (this.items[i].child[j].total) {
              total += parseFloat(this.items[i].child[j].total)
              if (parseInt(this.items[i].child[j].is_locked) === 1) {
                quoteTotal += parseFloat(this.items[i].child[j].total)
              } else {
                variationTotal += parseFloat(this.items[i].child[j].total)
              }
            }
          }
        }
        console.log('setGrandTotalAmount()')
        console.log(total)
        this.grandTotal = parseFloat(total).toFixed(2)
        this.quoteTotal = parseFloat(quoteTotal).toFixed(2)
        this.variationTotal = parseFloat(variationTotal).toFixed(2)
      },

      setTasks () {
        var mObj = JSON.parse(JSON.stringify(newObj))
        console.log(this.customerId)
        if (this.customerId === undefined) {
          this.items = mObj
        } else {
          this.$http({
            url: process.env.API_URL + '/api/customers/tasks/' + this.customerId + '/' + this.projectId,
            method: 'GET'
          }).then((res) => {
//            var data = []
            if (res.status === 204) {
              this.items = mObj
            } else if (res.status === 500) {
              this.setTasks()
            } else {
//              res.data.forEach((item, i) => {
//                item.newChild = newElem
//                data.push(item)
//              })
              this.items = res.data
            }
            this.setGrandTotalAmount()
          })
        }
      },

      updateParentTaskValue (data) {
        console.log('updating parent task')
        if (data.status === 'new') {
          this.items[data.key1].parent_id = 0
        } else {
          this.items[data.key1].parent_id = data.id
        }
        this.items[data.key1].parent = data.name
        this.items[data.key1].status = data.status
//        this.items[data.key1].child = []
//        this.items[data.key1].child.forEach((item, i) => {
//          item.sub_task = ''
//          item.sub_task_id = ''
//          item.is_cert_required = false
//          item.certificate_path = ''
//        })
      },

      updateNewTaskValue (data) {
        console.log('updating new task')
        console.log(data)
        this.items[data.key1].newChild.hasEmptySubTask = 0
        if (data.status === 'new') {
          this.items[data.key1].newChild.sub_task_id = 0
        } else {
          this.items[data.key1].newChild.sub_task_id = data.id
        }
        this.items[data.key1].newChild.is_cert_required = data.is_cert_required
        this.items[data.key1].newChild.sub_task = data.name
        this.items[data.key1].newChild.status = data.status
      },

      updateSubTaskValue (data) {
        console.log('updating child task')
        console.log(data)
        let subTaskId = 0
        if (data.status === 'existing') {
          subTaskId = data.id
        }
        this.items[data.key1].child[data.key2].sub_task_id = subTaskId
        this.items[data.key1].child[data.key2].is_cert_required = data.is_cert_required
        this.items[data.key1].child[data.key2].certificate_path = ''
        this.items[data.key1].child[data.key2].sub_task = data.name
        this.items[data.key1].child[data.key2].status = data.status
        let customerSubTaskId = this.items[data.key1].child[data.key2].customer_sub_task_id
        let parentTaskId = this.items[data.key1].parent_id

        if (data.name === '') return

        this.$http({
          url: process.env.API_URL + '/api/customers/tasks/update-customer-sub-task',
          method: 'PUT',
          data: {
            customerSubTaskId: customerSubTaskId,
            customerId: this.customerId,
            projectId: this.projectId,
            subTask: data.name,
            subTaskId: subTaskId,
            parentTaskId: parentTaskId
          }
        }).then((res) => {
        })
      },

      showModal (key) {
        this.manageMilestoneNotes = true
        this.currentMilestoneKey = key
        this.notes = this.items[this.currentMilestoneKey].notes
      },

      saveNotes () {
        this.items[this.currentMilestoneKey].notes = this.notes
        this.manageMilestoneNotes = false
        let customerMileStoneId = this.items[this.currentMilestoneKey].milestone_id
        this.ajaxUpdateMilestoneElement(customerMileStoneId, 'notes', this.notes)
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

      deleteParent (key1) {
        let milestoneId = this.items[key1].milestone_id
        if (milestoneId === '') {
          this.items.splice(key1, 1)
          return
        }
        this.$http({
          url: process.env.API_URL + '/api/customers/tasks/delete-parent-task',
          method: 'DELETE',
          data: {milestoneId: milestoneId, customerId: this.customerId, projectId: this.projectId}
        }).then((res) => {
          this.items.splice(key1, 1)
          this.setGrandTotalAmount()
        })
      },

      deleteRow (key1, key2) {
        var subTaskId = this.items[key1].child[key2].customer_sub_task_id
        this.$http({
          url: process.env.API_URL + '/api/customers/tasks/delete-sub-task',
          method: 'DELETE',
          data: {subTaskId: subTaskId, customerId: this.customerId, projectId: this.projectId}
        }).then((res) => {
          this.items[key1].child.splice(key2, 1)
//          if (this.items[key1].child.length === 0) {
//            location.reload()
//            this.items.splice(key1, 1)
//          }
          this.setGrandTotalAmount()
        })
      },

      updateTaskPosition (a) {
        console.log(a.from.parentNode.dataset.key)
        console.log(' dragComplete ')
        this.isDragging = false

        var key = a.from.parentNode.dataset.key
        var updatedJson = this.items[key].child
        this.$http({
          url: process.env.API_URL + '/api/customers/tasks/update-sub-task-position',
          method: 'PUT',
          data: {data: (updatedJson), customerId: this.customerId}
        }).then((res) => {
        })
      },

      addRow (data, key) {
//        this.errors.clear()
        if (data.sub_task === '') {
          this.items[key].newChild.hasEmptySubTask = 1
          // console.log(this.errors.remove('sub_task_new_0', 'taskNew'))
        }
        var scope = 'new_child_' + key
        this.$validator.validateAll(scope).then((result) => {
          if (result && data.sub_task !== '') {
            var dataJson = {
              'customer_id': this.customerId,
              'project_id': this.projectId,
              'parent_task': this.items[key].parent,
              'parent_task_id': this.items[key].parent_id,
              'child_task': data.sub_task,
              'child_task_id': data.sub_task_id,
              'quantity': data.quantity,
              'unit': data.unit,
              'rate': data.rate,
              'total': data.total,
              'certificate_path': data.certificate_path,
              'is_cert_required': data.is_cert_required,
              'child_position': this.items[key].child.length + 1,
              'parent_position': this.items.length + 1,
              'isVariation': 1
            }

            this.$http({
              url: process.env.API_URL + '/api/customers/tasks',
              method: 'POST',
              data: dataJson
            })
              .then((res) => {
                this.errors.clear()
                console.log(this.items[key].child.length)
                console.log(this.items[key].child.length)
                if (this.items[key].child.length === 0) {
                  console.log('Setting milestone id' + res.data.data.milestone_id)
                  this.items[key].milestone_id = res.data.data.milestone_id
                  this.items[key].parent_id = res.data.data.parent_id
                }

                this.items[key].child.push({
                  sub_task: data.sub_task,
                  sub_task_id: res.data.data.task_id,
                  customer_sub_task_id: res.data.data.id,
                  quantity: res.data.data.quantity,
                  unit: res.data.data.unit,
                  rate: res.data.data.rate,
                  total: res.data.data.total,
                  certificate_path: data.certificate_path,
                  is_cert_required: data.is_cert_required
                })

                this.setGrandTotalAmount()

                this.items[key].newChild.sub_task = ''
                this.items[key].newChild.sub_task_id = ''
                this.items[key].newChild.quantity = ''
                this.items[key].newChild.unit = ''
                this.items[key].newChild.rate = ''
                this.items[key].newChild.total = ''
                this.items[key].newChild.is_cert_required = false
                this.items[key].newChild.certificate_path = ''
//                this.$store.dispatch('setFlashMessage', {
//                  title: 'Subtask added',
//                  message: 'success',
//                  type: 'success'
//                })
              })
          } else {
            console.log('add new row validation fails')
            console.log(data.sub_task)
          }
        })
      },

      ajaxUpdateMilestoneElement (customerMileStoneId, name, value) {
        this.$http({
          url: process.env.API_URL + '/api/customers/tasks/update-milestone-element',
          method: 'PUT',
          data: {
            name: name,
            customerMileStoneId: customerMileStoneId,
            customerId: this.customerId,
            projectId: this.projectId,
            value: value
          }
        })
      },

      parentHandleChange (elem) {
        console.log('parentHandleChange')
        var isError = elem.target.parentElement.className.indexOf('has-error')

        var key = elem.target.dataset.key

        console.log('0. Error: ' + isError)
        if (isError !== -1 || key === undefined) return

        var name = elem.target.dataset.name
        console.log('name:' + name + 'key:' + key + 'value: ' + elem.target.value)

        var customerMileStoneId = this.items[key].milestone_id

        if (customerMileStoneId === undefined) return

        var value = elem.target.value

        if (name === 'amount') {
          console.log('1. errorOnPage: ' + this.errorOnPage)
          if (this.getTotalAmount() !== this.grandTotal) {
            console.log('2. Page validated...')
            elem.target.value = ''
          } else {
            this.ajaxUpdateMilestoneElement(customerMileStoneId, name, value)
          }
        } else {
          this.ajaxUpdateMilestoneElement(customerMileStoneId, name, value)
        }
      },

      handleChange (elem) {
        console.log('handleChange')
        console.log(elem)
        var isError = elem.target.parentElement.className.indexOf('has-error')
        console.log('Error: ' + isError)
        if (isError !== -1) return

        var name = elem.target.dataset.name
        var key1 = elem.target.dataset.key1
        var key2 = elem.target.dataset.key2
        console.log('name:' + name + 'key1:' + key1 + 'key2:' + key2 + 'value: ' + elem.target.value)
        if (name === undefined || key1 === undefined || key2 === undefined) {
          return
        }

        console.log('Customer Sub Task Id' + this.items[key1]['child'][key2].customer_sub_task_id)
        var customerSubTaskId = this.items[key1]['child'][key2].customer_sub_task_id
        var value = elem.target.value
        this.$http({
          url: process.env.API_URL + '/api/customers/tasks/update-customer-sub-task-element',
          method: 'PUT',
          data: {
            name: name,
            customerSubTaskId: customerSubTaskId,
            customerId: this.customerId,
            projectId: this.projectId,
            value: value
          }
        }).then((res) => {
          if (name === 'total') {
            this.setGrandTotalAmount()
          }
        })
      },

      inputChanged (value) {
        console.log('inputChanged')
      },

      getParentComponentData () {
        return {
          on: {
            change: this.parentHandleChange
          }
        }
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
      isDragging (newValue) {
        if (newValue) {
          this.delayedDragging = true
          return
        }
        this.$nextTick(() => {
          this.delayedDragging = false
        })
      },
      '$route' (to, from) {
        this.customerId = to.params.customerId
        this.projectId = to.params.projectId
      },
      customerId (newValue) {
        this.customerId = newValue
      },
      projectId (newValue) {
        this.projectId = newValue
      },
      activeTab (newValue) {
        if (newValue === 4) {
          this.setTasks()
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  p.notes{
    margin-bottom: 0;margin-top:5px;
  }
  input[type="date"]{
    padding-left: 0px;
  }
  /*input[type="date"]::-webkit-datetime-edit { padding: 1em; }*/
  /*input[type="date"]::-webkit-datetime-edit-fields-wrapper { background: silver; }*/
  /*input[type="date"]::-webkit-datetime-edit-text { color: red; padding: 0 0.3em; }*/
  /*input[type="date"]::-webkit-datetime-edit-month-field { color: blue; }*/
  /*input[type="date"]::-webkit-datetime-edit-day-field { color: green; }*/
  /*input[type="date"]::-webkit-datetime-edit-year-field { color: purple; }*/
  input[type="date"]::-webkit-inner-spin-button { display: none; }
  input[type="date"]::-webkit-calendar-picker-indicator {
    background: orange;
     margin-right: -10px
  }
  input[type="date"]::-webkit-clear-button { /* Removes blue cross */
    /*-webkit-appearance: none;*/
    margin: 0;
    /*padding-right: 5px;*/
  }
</style>
