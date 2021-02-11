<template>

  <div class="tasks-subtasks">

    <div class="container">
      <div class="row">
        <div class="col-sm-2 col-sm-offset-9 text-right">
          <h4>Client Total:</h4>
        </div>
        <div class="col-sm-1 text-right">
          <h4>${{grandTotal}}</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2 col-sm-offset-9 text-right">
          <h4>Budget Total:</h4>
        </div>
        <div class="col-sm-1 text-right">
          <h4>${{budgetTotal}}</h4>
        </div>
      </div>
      <div class="row " >
        <div class="col-sm-2 col-sm-offset-9 text-right " style="border-top:1px solid">
          <h4>Profit:</h4>
        </div>
        <div class="col-sm-1 text-right text-success" style="border-top:1px solid">
          <h4>${{profit}}</h4>
        </div>

      </div>
    </div>


      <div class="box box-info box-solid" v-for="(citems, key1, index) in items" :key="index">

        <div class="box-header" >
          <div class="row" >
            <div class="col-sm-1 parent-handle" >
              &nbsp;
            </div>

            <div class="col-sm-10">
              <div class="row hidden-xs" >

                <div class="col-sm-4 " >
                  <div class="form-group" >
                    <input class="form-control" v-model="citems.parent" disabled>
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="form-group">
                    <input type="date" class="form-control" v-model="citems.start_date" disabled>
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="form-group">
                    <input type="date" class="form-control" v-model="citems.end_date" disabled>
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="form-group">
                    <input type="text" class="form-control" v-model="citems.milestone" disabled>
                  </div>
                </div>

                <div class="col-sm-2 ">
                  <div class="form-group">
                    <input type="text" class="form-control" v-model="citems.amount" disabled>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-sm-1">
              &nbsp;
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

              <div class="list-complete-item" v-for="(citem, key2, cindex) in citems.child" v-bind:key="key2">

                <div class="row sub-task-row" >
                  <div class="col-sm-1 " >
                    &nbsp;
                  </div>
                  <div class="col-sm-10">
                    <div  >
                      <form >
                        <div class="row">

                          <div class="col-sm-4">
                            <div class="form-group">
                              <input type="text" class="form-control" v-model="citem.sub_task" disabled>
                            </div>
                          </div>

                          <div class="col-sm-2 ">
                            <div class="form-group">
                              <input type="text" class="form-control" v-model="citem.quantity" disabled>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group" >
                              <input type="text" class="form-control" v-model="citem.unit" disabled>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <input type="text" class="form-control" v-model="citem.rate" disabled>
                            </div>
                          </div>
                          <div class="col-sm-2" >
                            <div class="form-group">
                              <input type="text" class="form-control" v-model="citem.total" disabled>
                            </div>
                          </div>
                        </div>

                      </form>
                    </div>
                  </div>
                  <div class="col-sm-1">&nbsp;</div>
                </div>
                <div class="row sub-task-row" >
                  <div class="col-sm-1 " >
                    &nbsp;
                  </div>
                  <div class="col-sm-10">
                    <div  >
                      <form >
                        <div class="row">

                          <div class="col-sm-4">
                            <div class="form-group">
                              &nbsp;
                            </div>
                          </div>

                          <div class="col-sm-2 ">
                            <div class="form-group"  :class="{'has-error': errors.has('tasks.quantity_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.project_task_profits.quantity"
                                     placeholder="Quantity" v-bind:name="'quantity_'+key1+key2" maxlength="5"
                                     data-name="quantity" :data-key1="key1" :data-key2="key2"
                                     data-vv-scope="tasks"
                                     v-validate="'required|numeric'">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group" :class="{'has-error': errors.has('tasks.unit_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.project_task_profits.unit"
                                     placeholder="Unit" v-bind:name="'unit_'+key1+key2"
                                     data-name="unit" :data-key1="key1" :data-key2="key2"
                                     data-vv-scope="tasks"
                                     v-validate="'required'">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group" :class="{'has-error': errors.has('tasks.rate_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.project_task_profits.rate"
                                     placeholder="Rate" v-bind:name="'rate_'+key1+key2" maxlength="10"
                                     data-name="rate" :data-key1="key1" :data-key2="key2"
                                     data-vv-scope="tasks"
                                     v-validate="'required|decimal'">
                            </div>
                          </div>
                          <div class="col-sm-2" >
                            <div class="form-group" :class="{'has-error': errors.has('tasks.total_'+key1+key2)}">
                              <input type="text" class="form-control" v-model="citem.project_task_profits.total"
                                     placeholder="Total" v-bind:name="'total_'+key1+key2" maxlength="10"
                                     data-name="total" :data-key1="key1" :data-key2="key2"
                                     data-vv-scope="tasks"
                                     v-validate="'required|decimal'">
                            </div>
                          </div>
                        </div>

                      </form>
                    </div>
                  </div>
                  <div class="col-sm-1">
                    <button class="btn btn-sm" @click="saveRow(key1, key2)" type="button">Save</button>
                  </div>
                </div>

              </div>
        </div><!--.box-body-->
      </div><!--.box-->

    <!--<pre>{{ errors.has('sub_task_new_0') }}</pre>-->
    <!--<pre>customerId : {{ customerId }}</pre>-->
    <!--<pre>ProjectId : {{ projectId }}</pre>-->
    <!--<pre>{{ errors }}</pre>-->
    <!--<pre>{{ items }}</pre>-->

  </div>
</template>

<script>
  import Vue from 'vue'
  import VeeValidate from 'vee-validate'
  Vue.use(VeeValidate)
  export default {
    name: 'project-profit',
    components: {
    },
    data () {
      return {
        parentTasksArray: [],
        items: [],
        notes: '',
        grandTotal: 0,
        budgetTotal: 0,
        profit: 0,
        customerId: this.$route.params.customerId,
        projectId: this.$route.params.projectId,
        serverName: process.env.API_URL
      }
    },

    computed: {
      activeTab () {
        return this.$store.getters.getActiveTab
      }
    },

    created () {
//      if (this.activeTab === 3) {
//        this.setTasks()
//      }
    },

    methods: {
      saveRow (key1, key2) {
        if (this.items[key1].child[key2].project_task_profits.id === null) {
          this.insertRow(key1, key2)
        } else {
          this.updateRow(key1, key2)
        }
      },

      updateRow (key1, key2) {
        console.log('I am in update row')
        if (this.setGrandTotalAmount() === true) {
          let projectTaskProfitId = this.items[key1].child[key2].project_task_profits.id
          this.$http({
            url: process.env.API_URL + '/api/projects/tasks-profit/' + projectTaskProfitId,
            method: 'PUT',
            data: {
              quantity: this.items[key1].child[key2].project_task_profits.quantity,
              unit: this.items[key1].child[key2].project_task_profits.unit,
              rate: this.items[key1].child[key2].project_task_profits.rate,
              total: this.items[key1].child[key2].project_task_profits.total,
              grandTotal: this.grandTotal,
              budgetTotal: this.budgetTotal
            }
          }).then((res) => {
            this.setGrandTotalAmount()
          })
        }
      },

      insertRow (key1, key2) {
        console.log('I am in insert row')
        let projectTaskId = this.items[key1].child[key2].customer_sub_task_id
        if (this.setGrandTotalAmount() === true) {
          this.$http({
            url: process.env.API_URL + '/api/projects/tasks-profit',
            method: 'POST',
            data: {
              project_task_id: projectTaskId,
              quantity: this.items[key1].child[key2].project_task_profits.quantity,
              unit: this.items[key1].child[key2].project_task_profits.unit,
              rate: this.items[key1].child[key2].project_task_profits.rate,
              total: this.items[key1].child[key2].project_task_profits.total,
              grandTotal: this.grandTotal,
              budgetTotal: this.budgetTotal
            }
          }).then((res) => {
            this.items[key1].child[key2].project_task_profits.id = res.data.id
            this.setGrandTotalAmount()
          })
        }
      },

      setGrandTotalAmount () {
        let total = 0
        let budget = 0
        for (let i = 0; i < this.items.length; i++) {
          for (let j = 0; j < this.items[i].child.length; j++) {
            if (this.items[i].child[j].total) {
              total += parseFloat(this.items[i].child[j].total)
              if (this.items[i].child[j].project_task_profits.total) {
                budget += parseFloat(this.items[i].child[j].project_task_profits.total)
              }
            }
          }
        }
        console.log('Total Amount()')
        console.log(total)
        console.log('Budget total')
        console.log(budget)
        this.grandTotal = parseFloat(total).toFixed(2)
        this.budgetTotal = parseFloat(budget).toFixed(2)
        return true
      },

      setTasks () {
        if (this.projectId !== undefined) {
          this.$http({
            url: process.env.API_URL + '/api/projects/tasks-profit/' + this.projectId,
            method: 'GET'
          }).then((res) => {
            if (res.status === 500) {
              this.setTasks()
            }
            this.items = res.data
            this.setGrandTotalAmount()
          }).then((res) => {
            this.$validator.validateAll('tasks')
          })
        }
      }
    },
    watch: {
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
      budgetTotal (newValue) {
//        let profit = parseFloat(this.grandTotal - this.budgetTotal).toFixed(2)
        this.profit = (parseFloat(this.grandTotal) - parseFloat(this.budgetTotal)).toFixed(2)
      },
      activeTab (newValue) {
        if (newValue === 3) {
          this.setTasks()
        }
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>
