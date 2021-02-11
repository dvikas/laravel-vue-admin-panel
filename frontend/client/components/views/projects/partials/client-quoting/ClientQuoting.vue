<template>

  <div class="tasks-subtasks">

    <div class="box box-solid box-auto-height ">

      <div class="box-header with-border text-center">

        <div class="row " v-if="projectStatus === 0">

          <div class="col-sm-4 col-sm-offset-4">
            <draft-tyepahead :customer-id="customerId" :project-id="projectId"
                             @draftSelected="updateDraftJson"></draft-tyepahead>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-9 ">
            <div class="input-group">

              <form method="POST" enctype="multipart/form-data" class="form-inline text-left"
                    role="form" >
                <div class="form-group" v-if="projectStatus === 0">
                  <label><strong>Architectural Plan:</strong></label>
                </div>
                <div class="form-group " >
                  <image-upload file-name="arch_plan_file" :filePath="archPlanFile" v-if="projectStatus === 0"
                                key1="a" key2="z" :doCheckFileError="doCheckFileError"
                                category="project" @fileLoaded="afterImageLoaded"></image-upload>
                  <a v-if="archPlanFile" :href="serverName +'/storage/' + archPlanFile"
                     target="_blank"><i class="fa fa-paperclip"></i>&nbsp;Architectural Plan Document</a>
                </div>
              </form>

              <form method="POST" enctype="multipart/form-data" class="form-inline text-left"
                    role="form" >
                <div class="form-group" v-if="projectStatus === 0">
                  <label><strong>Engineering Plan:</strong></label>
                </div>
                <div class="form-group" >
                  <image-upload file-name="engg_plan_file" key1="a" key2="y" v-if="projectStatus === 0"
                                :doCheckFileError="doCheckFileError" :filePath="enggPlanFile"
                                category="project"  @fileLoaded="afterImageLoaded"></image-upload>
                  <a v-if="enggPlanFile" :href="serverName +'/storage/' + enggPlanFile"
                     target="_blank"><i class="fa fa-paperclip"></i>&nbsp;Engineering Plan Document</a>
                </div>
              </form>

              <form method="POST" enctype="multipart/form-data" class="form-inline text-left"
                    role="form" >
                <div class="form-group " v-if="projectStatus === 0">
                  <label><strong>Energy Efficiency:</strong></label>
                </div>
                <div class="form-group " >
                  <image-upload file-name="energy_eff_file"  key1="a" key2="z" v-if="projectStatus === 0"
                                :doCheckFileError="doCheckFileError" :filePath="energyEffFile"
                                 category="project" @fileLoaded="afterImageLoaded"></image-upload>
                  <a v-if="energyEffFile" :href="serverName +'/storage/' + energyEffFile"
                     target="_blank"><i class="fa fa-paperclip"></i>&nbsp;Energy Efficiency Document</a>
                </div>

              </form>

            </div>

          </div>
          <div class="col-sm-3" v-if="grandTotal">
            <span class="text-success pull-right" style="font-size:20px;"><em>TOTAL:</em>&nbsp;${{ grandTotal }}</span>
          </div>
        </div>
      </div>

    </div>

    <supplier-project-tasks :doErrorClear="doErrorClear" :todayDate="todayDate" :activeTab="activeTab"
      :customer-id="customerId" :project-id="projectId"></supplier-project-tasks>

    <fieldset :disabled="projectStatus === 1">
    <draggable :list="items"  :options="{handle:'.parent-handle'}" @start="isDragging=true"
               :component-data="getParentComponentData()" @end="updateParentTaskPosition" :move="onMove">
      <div class="box box-info box-solid" v-for="(citems, key1, index) in items" :key="index">

        <div class="box-header" >
          <div class="row" >
            <div class="col-sm-1 parent-handle" title="Move Parent Task" v-if="projectStatus === 0">
              <i class="fa fa-arrows-alt text-info"></i>
            </div>
            <div class="col-sm-1" v-else>&nbsp;</div>

            <div class="col-sm-10">
              <div class="row hidden-xs" >

                <div class="col-sm-4 " v-if="citems.child.length === 0 ">
                  <div class="input-group" :class="{'has-error': errors.has('parent_task_'+key1)}">

                    <tasks-typeahead  @taskSelected="updateParentTaskValue" :key1="key1" key2=""
                                      :taskValue="citems.parent"
                                      taskPlaceHolder="Search Parent Tasks" parentId="-1">
                    </tasks-typeahead>

                  </div>
                </div>
                <div class="col-sm-4 " v-else>
                  <div class="form-group" >
                    <input class="form-control" v-model="citems.parent" disabled>
                  </div>
                </div>

                <div class="col-sm-2 ">

                  <div class="form-group"
                       :class="{'has-error': errors.has('tasks.start_date'+key1)}">
                    <input type="date" lang="en" name="start_date" data-name="start_date" :data-key="key1" :key="key1"
                           class="form-control" v-model="citems.start_date" v-bind:name="'start_date'+key1"
                           :disabled = "citems.child.length === 0 "
                           v-validate="'required'"  data-vv-scope="tasks" :min="todayDate">
                  </div>
                </div>
                <div class="col-sm-2 ">
                  <div class="form-group"
                       :class="{'has-error': errors.has('tasks.end_date'+key1)}">
                    <input type="date"  name="end_date" :key="key1" data-name="end_date" :data-key="key1"
                           class="form-control" v-model="citems.end_date" v-bind:name="'end_date'+key1"
                           v-validate="'required'"  data-vv-scope="tasks" :min="citems.start_date"
                           :disabled = "citems.child.length === 0 ">
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="form-group"
                       :class="{'has-error': errors.has('tasks.milestone'+key1)}">
                    <input type="text" name="milestone" :key="key1" data-name="label" :data-key="key1"
                            class="form-control" v-model="citems.milestone" v-bind:name="'milestone'+key1"
                           :disabled = "citems.child.length === 0"
                           placeholder="Milestone" v-validate="'required'"  data-vv-scope="tasks" >
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="input-group"
                       :class="{'has-error': errors.has('tasks.amount'+key1)}">
                    <input type="text" class="form-control" data-name="amount" :data-key="key1"
                           name="amount" :key="key1" v-model="citems.amount" placeholder="Amount"
                           v-bind:name="'amount'+key1" v-validate="'required|decimal|min_value:1.00'"
                           data-vv-scope="tasks" :disabled = "citems.child.length === 0 ">

                    <div v-if="citems.child.length === 0 || projectStatus === 0" class="input-group-addon">
                      <i class="fa fa-pencil text-success"></i></div>
                    <div v-else class="input-group-addon"
                         @click="showModal(key1)"><i class="fa fa-pencil text-success"></i></div>

                  </div>

                </div>
              </div>
            </div>
            <div class="col-sm-1">
              <button @click="deleteParent(key1)" title="Delete Parent Task"
                      class="btn btn-danger" type="button"><i class="fa fa-trash-o"></i></button>
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
              <div class="list-complete-item" v-if="parseInt(citem.is_locked) === 1"
                   v-for="(citem, key2, cindex) in citems.child" v-bind:key="key2">

                <div class="row sub-task-row" style="transition: all 1s ease 1s;">
                  <div class="col-sm-1 handle" title="Move" v-if="projectStatus === 0">
                    <i class="fa fa-arrows-alt text-info"></i>
                  </div>
                  <div class="col-sm-1" v-else>&nbsp;</div>

                  <div class="col-sm-10">
                    <div  >
                      <form >
                        <div class="row">

                          <div class="col-sm-4 " v-if="projectStatus === 1">
                            <div class="form-group" >
                              <input class="form-control"  v-model="citem.sub_task" disabled>
                            </div>
                          </div>

                          <div class="col-sm-4" v-else>
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
                              <input type="number" class="form-control" v-model="citem.quantity" maxlength="5"
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
                              <image-upload :file-name="citem.customer_sub_task_id" :filePath="citem.certificate_path"
                                            category="customer_sub_task" :key1="key1" :key2="key2"
                                            :doCheckFileError="doCheckFileError" @fileLoaded="afterImageLoaded"></image-upload>
                              <a v-if="citem.certificate_path"
                                 :href="serverName +'/storage/' + citem.certificate_path" target="_blank">
                                <i class="fa fa-paperclip"></i>&nbsp;View Certificate</a>
                            </div>
                          </div>
                        </div>

                      </form>
                    </div>
                  </div>
                  <div class="col-sm-1">
                    <button  @click="deleteRow(key1, key2)" title="Delete subtask" class="btn btn-link" type="button">
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

                    <div class="col-sm-4 " v-if="projectStatus === 1">
                      <div class="form-group" >
                        <input class="form-control" disabled placeholder="Search Child Tasks">
                      </div>
                    </div>

                    <div class="col-sm-4" v-else>
                      <div class="form-group"  :class="{'has-error': citems.newChild.hasEmptySubTask === 1}">
                        <tasks-typeahead  @taskSelected="updateNewTaskValue" :key1="key1" key2=""
                                          taskPlaceHolder="Search Child Tasks"
                                          :taskValue="citems.newChild.sub_task"
                                          :doErrorClear="doErrorClear"
                                          :parentId="citems.parent_id">
                        </tasks-typeahead>
                      </div>
                    </div>

                    <div class="col-sm-2 ">
                      <div class="form-group"
                           :class="{'has-error': errors.has('new_child_'+key1+'.quantity_new_'+key1)}">
                        <input type="number" class="form-control" v-model="citems.newChild.quantity" maxlength="5"
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
              <button title="Add subtask"  @click="addRow(citems.newChild, key1)" type="button" class="btn btn-success btn-sm">Add</button>
            </div>
          </div>

        </div>
      </div><!--.box-->
    </draggable>


    <div class="row">
      <div class="col-sm-12">
        <button type="button"  @click="addNewTaskJson" class="btn btn-info">Add new Task</button>
      </div>
    </div>
    <div class="row " v-if="errorOnPage === true">
      <div class="col-sm-12 ">
        <div class="alert alert-danger col-sm-4 pull-right" >
          <strong class="text-danger">Please fix the errors on page.</strong>
          <ul v-if="errorMsgOnPage.length > 0">
            <li v-for="error in errorMsgOnPage" v-text="error"></li>
          </ul>
        </div>
      </div>

    </div>
    <div class="row mt-50">
      <div class="col-sm-6 form-inline">
        <div class="form-group " :class="{'has-error': errors.has('draft.draftName')}">
          <input  v-model="draftName" v-validate="'required'" class="form-control"
                 data-vv-scope="draft" name="draftName" placeholder="Template name">
          <button  type="button" @click="saveTaskAsDraft" class="btn btn-default">Save</button>
        </div>
      </div>
      <div class="col-sm-6 form-inline text-right">
        <button type="button "  @click="validatePage" class="btn btn-success">Save Details</button>

      </div>
    </div>
    </fieldset>

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

    <!--<pre>projectStatus: {{ projectStatus }}</pre>-->
    <!--<pre>customerId : {{ customerId }}</pre>-->
    <!--<pre>ProjectId : {{ projectId }}</pre>-->
    <pre>{{ errors }}</pre>
    <pre>{{ items }}</pre>

  </div>
</template>

<script>

  let newObj = [
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
  let obj = []
  import DraftTyepahead from '../../DraftTypeahead.vue'
  import TasksTypeahead from '../TasksTypeahead'
  import { modal } from 'vue-strap'
  import Vue from 'vue'
  import VeeValidate from 'vee-validate'
  import draggable from 'vuedraggable'
  import ImageUpload from '../ImageUpload'
  import SupplierProjectTasks from './SupplierProjectTasks'

  Vue.use(VeeValidate)

  export default {
    name: 'multi-dim',
    components: {
      SupplierProjectTasks,
      DraftTyepahead,
      TasksTypeahead,
//      typeahead,
      draggable,
      modal,
//      datepicker,
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
        draftName: '',
        customerId: this.$route.params.customerId,
        projectId: this.$route.params.projectId,
        serverName: process.env.API_URL,
        errorOnPage: false,
        errorMsgOnPage: [],
        pageValidated: false,
        doErrorClear: '',
        doCheckFileError: ''
      }
    },

    computed: {
      activeTab () {
        return this.$store.getters.getActiveTab
      },
      todayDate () {
        let now = new Date()
        let month = (now.getMonth() + 1)
        let day = now.getDate()
        if (month < 10) month = '0' + month
        if (day < 10) day = '0' + day
        return now.getFullYear() + '-' + month + '-' + day
      },
      archPlanFile () {
        return this.$store.getters.getArchPlanFile
      },
      enggPlanFile () {
        return this.$store.getters.getEnggPlanFile
      },
      energyEffFile () {
        return this.$store.getters.getEnergyEffFile
      },
      projectStatus: {
        get: function () {
          return parseInt(this.$store.getters.getProjectStatus)
        },
        set: function (newValue) {
        }
      }
    },

    created () {
//      if (this.activeTab === 1) {
//        this.setTasks()
//      }
    },

    methods: {

      errorInFileUpload () {
        let fileUploadError = false
        if (this.energyEffFile === '' || this.enggPlanFile === '' || this.archPlanFile === '') {
          fileUploadError = true
        }

        this.items.forEach((item, i) => {
          item.child.forEach((childTask, j) => {
            console.log(childTask.certificate_path === null)
            console.log(typeof childTask.certificate_path)
            if (childTask.is_cert_required === true &&
              childTask.certificate_path === null &&
              fileUploadError === false) {
              fileUploadError = true
            }
          })
        })
        return fileUploadError
      },

      updateDraftJson (data) {
//        console.log(data)
        this.items = data
      },

      saveTaskAsDraft () {
        var scope = 'draft'
        this.$validator.validateAll(scope).then((result) => {
          if (result) {
            this.$http({
              url: process.env.API_URL + '/api/users/draft-tasks',
              method: 'POST',
              data: {data: this.items, name: this.draftName}
            }).then((res) => {
              this.draftName = ''
              this.$store.dispatch('setFlashMessage', {
                message: 'Template added successfully',
                type: 'success'
              })
            })
          }
        })
      },

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
          } else if (category === 'project') {
            if (fileName === 'arch_plan_file') {
              this.$store.commit('setArchPlanFile', res.data.path)
//              this.archPlanFileError = ''
            } else if (fileName === 'engg_plan_file') {
              this.$store.commit('setEnggPlanFile', res.data.path)
//              this.enggPlanFileError = ''
            } else if (fileName === 'energy_eff_file') {
              this.$store.commit('setEnergyEffFile', res.data.path)
//              this.energyEffFileError = ''
            }
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

      clientQuoteSave () {
        this.$http({
          url: process.env.API_URL + '/api/projects/' + this.projectId,
          method: 'PUT',
          data: {field: 'tab_3_enabled', value: 1}
        }).then((res) => {
          if (res.status === 204) {
            this.$store.commit('setIsTab3enabled', 1)
            this.$store.commit('setActiveTab', 2)
            this.$store.dispatch('setFlashMessage', {
              message: 'Quotes saved successfully',
              type: 'success'
            })
          }
        })
      },

//      validateTopFilesUpload () {
//        if (this.energyEffFile === '') {
//          this.errorOnPage = true
//          this.energyEffFileError = 1
//          this.errorMsgOnPage.push('Please upload Energy Efficiency document')
//        }
//        if (this.enggPlanFile === '') {
//          this.errorOnPage = true
//          this.enggPlanFileError = 1
//          this.errorMsgOnPage.push('Please upload Engineering Plan document')
//        }
//        if (this.archPlanFile === '') {
//          this.errorOnPage = true
//          this.archPlanFileError = 1
//          this.errorMsgOnPage.push('Please upload Architectural Plan document')
//        }
//      },

      validatePage () {
        this.$validator.validateAll('tasks').then((result) => {
          this.errorMsgOnPage = []
          this.errorOnPage = false
          if (this.errorInFileUpload() === true) {
            this.errorOnPage = true
            this.errorMsgOnPage.push('Please upload all required documents')
          }

          if (this.items.length === 1 && this.items[0].child.length === 0) {
            this.errorOnPage = true
            this.errorMsgOnPage.push('Please add any task to continue')
          } else if (this.getTotalAmount() !== this.grandTotal) {
            this.errorOnPage = true
            this.errorMsgOnPage.push('Milestone amount should be equal to total amount')
          }

          this.doErrorClear = new Date().getTime() /* will set random string */
          this.doCheckFileError = new Date().getTime() /* will set random string */

          if (result === false) {
            this.errorOnPage = true
          }
          if (this.errorOnPage === false) {
            this.clientQuoteSave()
          }
          this.pageValidated = true
          console.log('Is Error:')
          console.log(this.errorOnPage)
          return this.errorOnPage
        })
      },

      addNewTaskJson () {
        var mObj = JSON.parse(JSON.stringify(newObj))
        this.items.push(...mObj)
        console.log(this.items)
      },

      setGrandTotalAmount () {
        let total = 0
        for (let i = 0; i < this.items.length; i++) {
          for (let j = 0; j < this.items[i].child.length; j++) {
            if (this.items[i].child[j].total && parseInt(this.items[i].child[j].is_locked) === 1) {
              total += parseFloat(this.items[i].child[j].total)
            }
          }
        }
        console.log('setGrandTotalAmount()')
        console.log(total)
        this.grandTotal = parseFloat(total).toFixed(2)
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
            if (res.status === 204) {
              this.items = mObj
            } else if (res.status === 500) {
              this.setTasks()
            } else {
              this.items = res.data
              this.setGrandTotalAmount()
            }
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

      updateParentTaskPosition (e) {
        console.log(' dragComplete parent')
        this.$http({
          url: process.env.API_URL + '/api/customers/tasks/update-milestone-position',
          method: 'PUT',
          data: {data: this.items}
        }).then((res) => {
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
          data: {data: (updatedJson)}
        }).then((res) => {
        })
      },

      addRow (data, key) {
        if (data.sub_task === '') {
          this.items[key].newChild.hasEmptySubTask = 1
        }

        var scope = 'new_child_' + key
        this.$validator.validateAll(scope).then((result) => {
          if (this.items[key].newChild.is_cert_required === true &&
            this.items[key].newChild.certificate_path === '') {
            return
          }
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
              'parent_position': this.items.length + 1
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
                console.log(this.items[key].child)
                this.items[key].child.push({
                  sub_task: data.sub_task,
                  sub_task_id: res.data.data.task_id,
                  customer_sub_task_id: res.data.data.id,
                  quantity: res.data.data.quantity,
                  unit: res.data.data.unit,
                  rate: res.data.data.rate,
                  total: res.data.data.total,
                  is_locked: 1,
                  certificate_path: data.certificate_path,
                  is_cert_required: data.is_cert_required
                })
                console.log(this.items[key].child)
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
        console.log(elem)
        console.log(elem.target.parentElement.className)
        console.log('parentHandleChange')
        let isError = elem.target.parentElement.className.indexOf('has-error')
        let key = elem.target.dataset.key
        let name = elem.target.dataset.name
        let value = elem.target.value

        console.log('name:' + name + 'key:' + key + 'value: ' + elem.target.value)
        console.log('0. Error: ' + isError)

        if (name === 'start_date' || name === 'end_date') {
          if (name === 'start_date') {
            this.items[key].end_date = ''
          }
          if (value === '') return
        } else if (isError !== -1 || key === undefined) {
          return
        }

        let customerMileStoneId = this.items[key].milestone_id

        if (customerMileStoneId === undefined) return

        if (name === 'amount') {
//          console.log('1. errorOnPage: ' + this.errorOnPage)
//          if (this.getTotalAmount() !== this.grandTotal) {
//            console.log('2. Page validated...')
//            elem.target.value = ''
//          } else {
          this.ajaxUpdateMilestoneElement(customerMileStoneId, name, value)
//          }
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
      activeTab (newValue) {
        if (newValue === 1) {
          this.setTasks()
          if (this.items.length === 0) {
            this.addNewTaskJson()
          }
        }
      },
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
      projectStatus (newValue) {
        this.projectStatus = newValue
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
