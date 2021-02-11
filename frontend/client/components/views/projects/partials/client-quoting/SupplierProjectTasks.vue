<template>
  <div class="box box-info box-solid box-auto-height ">
    <div class="box-header with-border text-center">
      <div class="row ">
        <div class="col-sm-11 col-sm-offset-1 text-left">
            <strong>ADD SUPPLIERS TASK</strong>
        </div>
      </div>
    </div>

    <fieldset :disabled="projectStatus === 1">
    <div class="box-body subtasks sub-tasks-box">
      <div class="row sub-task-header">
        <div class="col-sm-1">&nbsp;</div>
        <div class="col-sm-10">
          <div class="row hidden-xs" >
            <div class="col-sm-4 " >
              <label>Task</label>
            </div>
            <div class="col-sm-2 " >
              <label>Quantity</label>
            </div>
            <div class="col-sm-2" >
              <label>Unit</label>
            </div>
            <div class="col-sm-2">
              <label>End date</label>
            </div>
            <div class="col-sm-2" >
              &nbsp;
            </div>
          </div>
        </div>
        <div class="col-sm-1">
          &nbsp;
        </div>
      </div>

      <div v-for="(supplierProjectTask, index) in supplierProjectTasks" class="row sub-task-row ">
        <div class="col-sm-1">
          &nbsp;
        </div>
        <div class="col-sm-10">
          <div class="row hidden-xs" >
            <div class="col-sm-4 " >
              <div class="form-group"
                   :class="{'has-error': errors.has('supplierProjectTask_'+index+'.supplierProjectTaskName_'+index)}">
                <select class="form-control" @change="updateSupplierProjectTask(index)"
                        v-model="supplierProjectTasks[index].supplierUserTask.uuid"
                        v-bind:name="'supplierProjectTaskName_'+index"
                        :data-vv-scope="'supplierProjectTask_'+index" v-validate="'required'">
                  <option value="">-Select-</option>
                  <option v-for="task in supplierTasks" :value="task.id">{{ task.name }}</option>
                </select>
              </div>
            </div>
            <div class="col-sm-2 " >
              <div class="form-group"
                   :class="{'has-error': errors.has('supplierProjectTask_'+index+'.supplierProjectTaskQuatity_'+index)}">
                <input type="text" class="form-control" maxlength="5" v-model="supplierProjectTasks[index].quantity"
                       placeholder="Quantity" @change="updateSupplierProjectTask(index)"
                       v-bind:name="'supplierProjectTaskQuatity_'+index"
                       :data-vv-scope="'supplierProjectTask_'+index" v-validate="'required|decimal'">
              </div>
            </div>
            <div class="col-sm-2" >
              <div class="form-group"
                   :class="{'has-error': errors.has('supplierProjectTask_'+index+'.supplierProjectTaskUnit_'+index)}">
                <input type="text" class="form-control" maxlength="5" v-model="supplierProjectTasks[index].unit"
                       placeholder="Unit" @change="updateSupplierProjectTask(index)"
                       v-bind:name="'supplierProjectTaskUnit_'+index"
                       :data-vv-scope="'supplierProjectTask_'+index"  v-validate="'required'">
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group "
                   :class="{'has-error': errors.has('supplierProjectTask_'+index+'.supplierProjectTaskDeadline_'+index)}">
                <input type="date" name="end_date" class="form-control"  @change="updateSupplierProjectTask(index)"

                       v-model="supplierProjectTasks[index].deadline" v-bind:name="'supplierProjectTaskDeadline_'+index"
                       :data-vv-scope="'supplierProjectTask_'+index"  v-validate="'required'">
              </div>
            </div>
            <div class="col-sm-2" >&nbsp;</div>
          </div>
        </div>
        <div class="col-sm-1">
          <button @click="deleteSupplierProjectTask(index)"  title="Delete Task" class="btn btn-link btn-danger"
                  type="button">
            <i class="fa fa-trash-o text-maroon"></i></button>
        </div>
      </div>

    </div>

    <div class="box-footer subtasks" slot="footer" >

      <div class="row sub-task-row">
        <div class="col-sm-1">&nbsp;</div>
        <div class="col-sm-10">
          <div  >
            <form >
              <div class="row">

                <div class="col-sm-4">
                  <div class="form-group"
                       :class="{'has-error': errors.has('newSupplierProjectTask.supplierProjectTaskName')}">
                    <select class="form-control" v-bind:name="'supplierProjectTaskName'"
                            data-vv-scope="newSupplierProjectTask"  v-model="supplierProjectTaskName"
                              v-validate="'required'" >
                      <option value="">-Select-</option>
                      <option v-for="task in supplierTasks" :value="task.id" v-if="task.suppliers.length > 0">{{ task.name }}</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="form-group"
                       :class="{'has-error': errors.has('newSupplierProjectTask.supplierProjectTaskQuantity')}">
                    <input type="number" class="form-control"  maxlength="5" v-model="supplierProjectTaskQuantity"
                           placeholder="Quantity" v-bind:name="'supplierProjectTaskQuantity'"
                           data-vv-scope="newSupplierProjectTask" v-validate="'required|decimal'"/>
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group"
                       :class="{'has-error': errors.has('newSupplierProjectTask.supplierProjectTaskUnit')}">
                    <input type="text" class="form-control" placeholder="Unit"  v-model="supplierProjectTaskUnit"
                           v-bind:name="'supplierProjectTaskUnit'" maxlength="20"
                           data-vv-scope="newSupplierProjectTask" v-validate="'required'"/>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group "
                       :class="{'has-error': errors.has('newSupplierProjectTask.supplierProjectTaskDeadline')}">
                    <input type="date" name="end_date" class="form-control" :min="todayDate"
                           v-bind:name="'supplierProjectTaskDeadline'"  v-model="supplierProjectTaskDeadline"
                           data-vv-scope="newSupplierProjectTask" v-validate="'required'">
                  </div>
                </div>

                <div class="col-sm-2" ></div>
              </div>

            </form>
          </div>
        </div>
        <div class="col-sm-1">
          <button title="Add subtask"  @click="saveSupplierProjectTask" type="button"
                  class="btn btn-success btn-sm">Add</button>
        </div>
      </div>

    </div>
    </fieldset>
    <!--<pre>{{ errors }}</pre>-->
    <!--<pre>{{ supplierProjectTasks }}</pre>-->

  </div>
</template>
<script>
  import Vue from 'vue'
  import VeeValidate from 'vee-validate'
  Vue.use(VeeValidate, {
    inject: false,
    delay: 500
  })

  export default{
    name: 'supplier-project-tasks',
    props: ['customerId', 'projectId', 'doErrorClear', 'todayDate', 'activeTab'],
    data () {
      return {
        supplierTasks: '',
        supplierProjectTaskName: '',
        supplierProjectTaskUnit: '',
        supplierProjectTaskDeadline: '',
        supplierProjectTaskQuantity: '',
        supplierProjectTasks: []
      }
    },
    computed: {
//      activeTab () {
//        return this.$store.getters.getActiveTab
//      },
      projectStatus: {
        get: function () {
          return parseInt(this.$store.getters.getProjectStatus)
        },
        set: function (newValue) {
        }
      }
    },
    created () {
      if (this.activeTab === 1) {
        this.getTasks()
        this.getSupplierProjectTasks()
      }
    },

    methods: {
      getTasks () {
        this.$http({
          url: process.env.API_URL + '/api/suppliers/tasks',
          method: 'GET'
        }).then((res) => {
          if (res.status === 500) {
            this.getTasks()
          }
          this.supplierTasks = res.data.data
        })
      },

      saveSupplierProjectTask () {
        var scope = 'newSupplierProjectTask'
        this.$validator.validateAll(scope).then((result) => {
          let supplierProjectTaskName = this.supplierProjectTaskName
          let supplierProjectTaskQuantity = this.supplierProjectTaskQuantity
          let supplierProjectTaskUnit = this.supplierProjectTaskUnit
          let supplierProjectTaskDeadline = this.supplierProjectTaskDeadline
          this.supplierProjectTaskName = ''
          this.supplierProjectTaskQuantity = ''
          this.supplierProjectTaskUnit = ''
          this.supplierProjectTaskDeadline = ''

          if (result) {
            this.$http({
              url: process.env.API_URL + '/api/suppliers/projects/tasks',
              method: 'POST',
              data: {
                supplier_user_task_id: supplierProjectTaskName,
                project_id: this.projectId,
                quantity: supplierProjectTaskQuantity,
                unit: supplierProjectTaskUnit,
                deadline: supplierProjectTaskDeadline
              }
            }).then((res) => {
              this.errors.clear('newSupplierProjectTask')
              this.supplierProjectTasks.push({
                id: res.data.id,
                quantity: supplierProjectTaskQuantity,
                unit: supplierProjectTaskUnit,
                deadline: supplierProjectTaskDeadline,
                supplierUserTask: {uuid: supplierProjectTaskName}
              })
            })
          }
        })
      },

      getSupplierProjectTasks () {
        if (this.projectId !== undefined) {
          this.$http({
            url: process.env.API_URL + '/api/suppliers/projects/tasks/' + this.projectId,
            method: 'GET'
          }).then((res) => {
            if (res.status === 500) {
              this.getSupplierProjectTasks()
            }
            this.supplierProjectTasks = res.data.data
          })
        }
      },

      deleteSupplierProjectTask (index) {
        let id = this.supplierProjectTasks[index].id
        this.$http({
          url: process.env.API_URL + '/api/suppliers/projects/tasks/' + id,
          method: 'DELETE'
        }).then((res) => {
          if (res.status === 204) {
            this.supplierProjectTasks.splice(index, 1)
          }
        })
      },

      updateSupplierProjectTask (index) {
        console.log('Updating ' + index)
        var scope = 'supplierProjectTask_' + index
        this.$validator.validateAll(scope).then((result) => {
          if (result) {
            let id = this.supplierProjectTasks[index].id
            this.$http({
              url: process.env.API_URL + '/api/suppliers/projects/tasks/' + id,
              method: 'PUT',
              data: {
                supplier_user_task_id: this.supplierProjectTasks[index].supplierUserTask.uuid,
                project_id: this.projectId,
                quantity: this.supplierProjectTasks[index].quantity,
                unit: this.supplierProjectTasks[index].unit,
                deadline: this.supplierProjectTasks[index].deadline
              }
            })
          }
        })
      }
    },
    watch: {
      doErrorClear () {
        this.errors.clear('newSupplierProjectTask')
      },
      activeTab (newValue) {
        if (newValue === 1) {
          this.getTasks()
          this.getSupplierProjectTasks()
        }
      },
      projectStatus (newValue) {
        this.projectStatus = newValue
      }
    }
  }
</script>
