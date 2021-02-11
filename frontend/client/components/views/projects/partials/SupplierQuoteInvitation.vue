<template>
  <div>
    <div class="box box-info box-solid box-auto-height " v-for="(supplierProjectTask, index) in supplierProjectTasks" >
      <!--<div class="box-header with-border text-center">-->
      <!--<div class="row ">-->
      <!--<div class="col-sm-12">-->
      <!--<strong>SUPPLIERS TASK</strong>-->
      <!--</div>-->
      <!--</div>-->
      <!--</div>-->

      <div class="box-body subtasks sub-tasks-box">
        <div class="row sub-task-header">
          <div class="col-sm-11">
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

        <div class="row sub-task-row ">

          <div class="col-sm-11">
            <div class="row hidden-xs" >
              <div class="col-sm-4 " >
                <div class="form-group"
                     :class="{'has-error': errors.has('supplierProjectTask_'+index+'.supplierProjectTaskName_'+index)}">
                  <select class="form-control" @change="updateSupplierProjectTask(index)"
                          v-model="supplierProjectTasks[index].supplierUserTask.uuid"
                          v-bind:name="'supplierProjectTaskName_'+index" disabled
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
                         v-bind:name="'supplierProjectTaskQuatity_'+index" disabled
                         :data-vv-scope="'supplierProjectTask_'+index" v-validate="'required|decimal'">
                </div>
              </div>
              <div class="col-sm-2" >
                <div class="form-group"
                     :class="{'has-error': errors.has('supplierProjectTask_'+index+'.supplierProjectTaskUnit_'+index)}">
                  <input type="text" class="form-control" maxlength="5" v-model="supplierProjectTasks[index].unit"
                         placeholder="Unit" @change="updateSupplierProjectTask(index)"
                         v-bind:name="'supplierProjectTaskUnit_'+index" disabled
                         :data-vv-scope="'supplierProjectTask_'+index"  v-validate="'required'">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group "
                     :class="{'has-error': errors.has('supplierProjectTask_'+index+'.supplierProjectTaskDeadline_'+index)}">
                  <input type="date" name="end_date" class="form-control"  @change="updateSupplierProjectTask(index)"
                         disabled
                         v-model="supplierProjectTasks[index].deadline" v-bind:name="'supplierProjectTaskDeadline_'+index"
                         :data-vv-scope="'supplierProjectTask_'+index"  v-validate="'required'">
                </div>
              </div>
              <div class="col-sm-2" >&nbsp;</div>
            </div>
          </div>
          <div class="col-sm-1">
            &nbsp;
          </div>

          <div class="col-sm-12">
            <!--<pre>{{ supplierTasks }} </pre>-->
            <div class="row" v-for="supplierTask in supplierTasks"
                 v-if="supplierTask.id === supplierProjectTasks[index].supplierUserTask.uuid">
              <div class="col-sm-4">
                <ul class="list-group">
                  <li class="list-group-item list-group-item-info"><strong>Select Suppliers</strong></li>
                  <li class="list-group-item " v-for="supplier in supplierTask.suppliers">
                    <label><input type="checkbox"
                                  :value="supplier.uuid"
                                  v-model="supplierProjectTasks[index]['suppliers']"
                                  :data-id="supplier.uuid"> &nbsp;{{ supplier.name }}</label>
                  </li>
                  <li class="list-group-item list-group-item-success">
                    <label><input type="checkbox"
                                  :checked = "supplierProjectTasks[index]['suppliers'].length === supplierTask.suppliers.length"
                                  :data-suppliers="JSON.stringify(supplierTask.suppliers)"
                                  :data-index="index"
                                  @click="selectAll"> &nbsp;Select All</label>
                  </li>
                </ul>

              </div>
              <div class="col-sm-8 ">
                <div class="form-group" v-for="(quoteDetails, i) in supplierProjectTask['supplierQuoteDetails']" v-if="i===0"
                     :class="{'has-error': errors.has('task_'+index+'.notes_'+index)}">
                  <textarea class="form-control"  v-bind:name="'notes_'+index" v-validate="'required'"
                            v-model="quoteDetails.user_notes" :data-vv-scope="'task_'+index"
                            rows="3" placeholder="Message"></textarea>

                </div>
                <div class="form-group" v-if="supplierProjectTask['supplierQuoteDetails'].length === 0"
                     :class="{'has-error': errors.has('task_'+index+'.notes_'+index)}">
                  <textarea class="form-control"  v-bind:name="'notes_'+index" v-validate="'required'"
                            :data-vv-scope="'task_'+index"
                            v-model="supplierProjectTask.user_notes" rows="3" placeholder="Message"></textarea>

                </div>
                <!--<pre>{{ supplierProjectTask }}</pre>-->
                <!--<pre>{{ supplierProjectTasks[index]['supplierQuoteDetails'][index].uuid }}</pre>-->
                <div class="alert alert-danger " v-if="supplierProjectTask.errors.length > 0">
                  <div v-for="msg in supplierProjectTask.errors">{{ msg }}</div>
                </div>

                <button class="btn btn-primary pull-right" @click="sendProposalToSelected(index)"><i class="fa fa-envelope-o"></i> Send selected</button>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!--<pre>{{ errors }}</pre>-->

      <div style="margin:0px 10px;" >
        <div class="box box-default box-solid tasks-subtasks">

          <div class="box-header with-border text-center">
            <div class="row ">
              <div class="col-sm-12 text-left">
                <strong>Suppliers Quotes</strong>
              </div>
            </div>
          </div>

          <div class="box-body subtasks sub-tasks-box ">
            <div class="row sub-task-header">
              <div class="col-sm-12">
                <div class="row hidden-xs" >
                  <div class="col-sm-2" >
                    <label>Supplier Name</label>                    &nbsp;
                  </div>
                  <div class="col-sm-4 " >
                    <label>Supplier Message</label>
                  </div>
                  <div class="col-sm-1 " >
                    <label>Rate</label>
                  </div>
                  <div class="col-sm-1" >
                    <label>Total</label>
                  </div>
                  <div class="col-sm-2">
                    <label>Status</label>
                  </div>
                  <div class="col-sm-2">
                    <label>Sent On</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="list-complete-item" v-for="quotes in supplierProjectTask['supplierQuoteDetails']">
              <div class="row sub-task-row " >

                <div class="col-sm-2" >
                  <span>{{ quotes.supplier.name }}</span>      &nbsp;
                </div>
                <div class="col-sm-4 " >
                  <span v-if="quotes.supplier_notes">{{ quotes.supplier_notes }}</span>
                  <span v-else><code>---</code></span>
                </div>
                <div class="col-sm-1 " >
                  <span v-if="quotes.supplier_rate">${{ quotes.supplier_rate }}</span>
                  <span v-else><code>---</code></span>
                </div>
                <div class="col-sm-1" >
                  <span v-if="quotes.supplier_total">${{ quotes.supplier_total }}</span>
                  <span v-else><code>---</code></span>
                </div>
                <div class="col-sm-2">
                  <span v-if="quotes.accepted_at">
                    <span class="label label-success">Accepted on {{ quotes.accepted_at | moment("MM-D-YYYY") }}</span></span>
                  <span v-else><span class="label label-warning">Waiting</span></span>
                </div>
                <div class="col-sm-2">
                  {{ quotes.sent_at | moment("MM-D-YYYY") }}
                </div>

              </div>

            </div>

            <div class="list-complete-item" v-if="supplierProjectTask['supplierQuoteDetails'].length === 0">
              <div class="row sub-task-row " >
                <div class="col-sm-12 text-danger" >
                  Record not found. Please sent invitations.
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
    <!--<pre>{{ errors }}</pre>-->
    <!--<pre>{{ supplierProjectTasks }}</pre>-->
    <div v-if="supplierProjectTaskLoader === 1 && supplierProjectTasks.length === 0" class="alert alert-info">
      <i class="fa fa-refresh fa-spin"></i> Loading&hellip;
    </div>
    <div v-if="supplierProjectTaskLoader === 0 && supplierProjectTasks.length === 0" class="alert alert-danger">
      <i class="fa fa-info-circle"></i> Sorry, suppliers not found!
    </div>


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
    name: 'supplier-quote-invitation',
//    props: ['customerId', 'projectId', 'doErrorClear'],
    data () {
      return {
        customerId: this.$route.params.customerId,
        projectId: this.$route.params.projectId,
        serverName: process.env.API_URL,
        supplierTasks: '',
        supplierProjectTaskName: '',
        supplierProjectTaskUnit: '',
        supplierProjectTaskDeadline: '',
        supplierProjectTaskQuantity: '',
        supplierProjectTasks: [],
        supplierProjectTaskLoader: 0
//        errorMsg: []
      }
    },
    computed: {
      activeTab () {
        return this.$store.getters.getActiveTab
      },
      projectStatus () {
        return this.$store.getters.getProjectStatus
      },
      disabled () {
//        return this.projectStatus === 1
        return false
      }
    },
    created () {
//      if (this.activeTab === 6) {
//        this.getTasks()
//        this.getSupplierProjectTasks()
//      }
    },

    methods: {

      sendProposalToSelected (index) {
        const suppliers = this.supplierProjectTasks[index].suppliers
        const id = this.supplierProjectTasks[index].id
        this.supplierProjectTasks[index].errors = []

        let userNotes = ''
        if (this.supplierProjectTasks[index].supplierQuoteDetails.length === 0) {
          userNotes = this.supplierProjectTasks[index].user_notes
        } else {
          userNotes = this.supplierProjectTasks[index].supplierQuoteDetails[0].user_notes
        }
        if (userNotes === '') {
          this.supplierProjectTasks[index].errors.push('Message should not be blank')
        }
        if (suppliers.length === 0) {
          this.supplierProjectTasks[index].errors.push('Please select any supplier')
        }
        let scope = 'task_' + index
        this.$validator.validateAll(scope).then((result) => {
          if (result) {
            if (this.supplierProjectTasks[index].errors.length === 0) {
              this.$http({
                url: this.serverName + '/api/supplier/quotes',
                method: 'POST',
                data: {
                  id: id,
                  suppliers: suppliers,
                  notes: userNotes
                }
              }).then((res) => {
                this.$store.dispatch('setFlashMessage', {
                  message: 'Invitation has been sent to selected suppliers',
                  type: 'success'
                })
                this.getSupplierProjectTasks()
              })
            }
          }
        })
      },

      selectAll (elem) {
//        console.log(elem.target.checked)
        const isChecked = elem.target.checked
        const index = elem.target.dataset.index
        if (isChecked === true) {
          let suppliersArray = []
          let suppliers = JSON.parse(elem.target.dataset.suppliers)
          suppliers.forEach((data) => {
            suppliersArray.push(data.uuid)
          })
          this.$set(this.supplierProjectTasks[index], 'suppliers', suppliersArray)
        } else {
          this.$set(this.supplierProjectTasks[index], 'suppliers', [])
        }
      },

      getTasks () {
        this.$http({
          url: this.serverName + '/api/suppliers/tasks',
          method: 'GET'
        }).then((res) => {
          if (res.status === 500) {
            this.getTasks()
          }
          this.supplierTasks = res.data.data
        })
      },

//      saveSupplierProjectTask () {
//        var scope = 'newSupplierProjectTask'
//        this.$validator.validateAll(scope).then((result) => {
//          let supplierProjectTaskName = this.supplierProjectTaskName
//          let supplierProjectTaskQuantity = this.supplierProjectTaskQuantity
//          let supplierProjectTaskUnit = this.supplierProjectTaskUnit
//          let supplierProjectTaskDeadline = this.supplierProjectTaskDeadline
//          this.supplierProjectTaskName = ''
//          this.supplierProjectTaskQuantity = ''
//          this.supplierProjectTaskUnit = ''
//          this.supplierProjectTaskDeadline = ''
//
//          if (result) {
//            this.$http({
//              url: this.serverName + '/api/suppliers/projects/tasks',
//              method: 'POST',
//              data: {
//                supplier_user_task_id: supplierProjectTaskName,
//                project_id: this.projectId,
//                quantity: supplierProjectTaskQuantity,
//                unit: supplierProjectTaskUnit,
//                deadline: supplierProjectTaskDeadline
//              }
//            }).then((res) => {
//              this.errors.clear('newSupplierProjectTask')
//              this.supplierProjectTasks.push({
//                id: res.data.id,
//                quantity: supplierProjectTaskQuantity,
//                unit: supplierProjectTaskUnit,
//                deadline: supplierProjectTaskDeadline,
//                supplierUserTask: {uuid: supplierProjectTaskName}
//              })
//            })
//          }
//        })
//      },

      getSupplierProjectTasks () {
        if (this.projectId !== undefined) {
          this.supplierProjectTaskLoader = 1
          this.$http({
            url: this.serverName + '/api/suppliers/projects/tasks/' + this.projectId,
            method: 'GET'
          }).then((res) => {
            if (res.status === 500) {
              this.getSupplierProjectTasks()
            }
            let supplierData = res.data.data
//            console.log(supplierData)
            supplierData.forEach((obj, index) => {
//              console.log(obj)
              this.$set(supplierData[index], 'suppliers', [])
              this.$set(supplierData[index], 'user_notes', '')
              this.$set(supplierData[index], 'errors', [])
            })
            this.supplierProjectTasks = supplierData
            this.supplierProjectTaskLoader = 0
          })
        }
      }

//      updateSupplierProjectTask (index) {
//        console.log('Updating ' + index)
//        var scope = 'supplierProjectTask_' + index
//        this.$validator.validateAll(scope).then((result) => {
//          if (result) {
//            let id = this.supplierProjectTasks[index].id
//            this.$http({
//              url: this.serverName + '/api/suppliers/projects/tasks/' + id,
//              method: 'PUT',
//              data: {
//                supplier_user_task_id: this.supplierProjectTasks[index].supplierUserTask.uuid,
//                project_id: this.projectId,
//                quantity: this.supplierProjectTasks[index].quantity,
//                unit: this.supplierProjectTasks[index].unit,
//                deadline: this.supplierProjectTasks[index].deadline
//              }
//            })
//          }
//        })
//      }
    },
    watch: {
      doErrorClear () {
        this.errors.clear('newSupplierProjectTask')
      },
      activeTab (newValue) {
        if (this.activeTab === 5) {
          this.getTasks()
          this.getSupplierProjectTasks()
        }
      },
      '$route' (to, from) {
        this.customerId = to.params.customerId
        this.projectId = to.params.projectId
      }
    }
  }
</script>

<style lang="scss" scoped>

  .box.box-solid.box-info {
    box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.2);
    margin-bottom:30px;
  }
</style>
