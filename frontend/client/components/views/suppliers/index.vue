<template>
  <div>
    <section class="content-header">
      <h1>All Suppliers</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Suppliers</li>
      </ol>
    </section>
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-xs-8">
          <!-- TABLE: LATEST PROJECTS -->
          <div class="box box-info">
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6">
                    <div class="pull-right">
                        <input class="form-control input-sm" placeholder="Search"
                              v-model="searchTxt" type="search">
                      <button @click="fetchSuppliers" class="btn btn-sm btn-default">
                        <i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <table class="table" role="grid" cellpadding="0" cellspacing="0">
                      <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>ABN</th>
                        <th>ACN</th>
                        <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody v-for="(supplier, index) in suppliers">

                      <tr :class=" index % 2 !== 0 ? 'active' :''">
                        <td>{{ supplier.name }}</td>
                        <td>{{ supplier.email }}</td>
                        <td>{{ supplier.phone }}</td>
                        <td>{{ supplier.address }}</td>
                        <td>{{ supplier.abn }}</td>
                        <td>{{ supplier.acn }}</td>
                        <td>
                          <a href="javascript:void(0)" title="Edit"
                             v-on:click.prevent="editSupplier(supplier)"><i class="fa fa-edit"></i></a>&nbsp;
                          <a href="javascript:void(0)" title="Delete"
                             v-on:click.prevent="deleteSupplierOpenModal(supplier)"><i
                            class="fa fa-trash text-maroon"></i></a>
                        </td>
                      </tr>
                      <tr :class=" index % 2 !== 0 ? 'active' :''">
                        <td colspan="7">
                          <div v-if="supplier.tasks.length > 0">
                    <span v-for="task in supplier.tasks">
                      <span class="label label-info"><i class="fa fa-tag"></i> {{ task.name }}</span>&nbsp;&nbsp;
                    </span>
                          </div>
                          <div v-else>
                            <span class="text-danger">No Tasks found.</span>
                          </div>
                        </td>
                      </tr>

                      </tbody>
                    </table></div></div>
                <div class="row">
                  <div class="col-sm-5">
                    <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                      &nbsp;
                    </div>
                  </div>
                  <div class="col-sm-7">
                    <paginator :dataSet="paginationData" @updatePaginate="fetchSuppliers"></paginator>
                  </div>
                </div>
              </div>

              <div v-if="suppliersLoader === 1 && suppliers.length === 0" class="alert alert-info">
                <i class="fa fa-refresh fa-spin"></i> Loading&hellip;
              </div>
              <div v-if="suppliersLoader === 0 && suppliers.length === 0" class="alert alert-danger">
                <i class="fa fa-info-circle"></i> Sorry, suppliers not found!
              </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!--<pre>{{ suppliers }}</pre>-->
          <!--<pre>{{ tasks }}</pre>-->
          <!--<pre>{{ selectedSuppliersTasks }}</pre>-->
          <!--<pre>{{ suppliersTasks }}</pre>-->
          <!-- /.box -->
        </div>
        <div class="col-xs-4">
          <div class="box box-info">
            <div class="box-body">
              <h4 v-if="id === ''">Add new Supplier</h4>
              <h4 v-else>Edit Supplier</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form v-on:submit.prevent="id === '' ? saveSupplier() : updateSupplier()">
                <div class="form-group">
                  <label for="supplierNameId">Name</label>
                  <input type="text" required class="form-control" id="supplierNameId" v-model="name"
                         placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="supplierEmailId">Email address</label>
                  <input type="email" required class="form-control" id="supplierEmailId" v-model="email"
                         placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="supplierPhoneId">Phone</label>
                  <input type="text" required class="form-control" id="supplierPhoneId" v-model="phone"
                         placeholder="Phone">
                </div>
                <div class="form-group">
                  <label for="supplierAddressId">Address</label>
                <textarea required class="form-control" id="supplierAddressId" v-model="address"
                          placeholder="Address"></textarea>
                </div>
                <div class="form-group">
                  <label for="supplierAbn">A.B.N</label>
                  <input type="text" class="form-control" id="supplierAbn" placeholder="ABN" v-model="abn">
                </div>
                <div class="form-group">
                  <label for="supplierAcn">A.C.N</label>
                  <input type="text" class="form-control" id="supplierAcn" placeholder="ACN" v-model="acn">
                </div>
                <div class="form-group">
                  <label for="supplierTasks">Tasks</label>
                  <select class="form-control" id="supplierTasks" multiple v-model="selectedSuppliersTasks">
                    <option  v-for="suppliersTask in suppliersTasks" :value="suppliersTask.id">{{ suppliersTask.name }}
                             </option>
                  </select>
                </div>

                <button v-if="id === ''" type="submit" class="btn btn-success">Add</button>
                <button v-else type="submit" class="btn btn-primary">Update</button>
                <button v-if="id !== ''" type="reset" @click="resetData" class="btn btn-warning pull-right">Cancel</button>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    </section>

    <modal v-model="deleteSupplierModal" effect="fade">
      <div slot="modal-header" class="modal-header">
        <h4 class="modal-title">
          <b>Delete</b>
        </h4>
      </div>
      <div slot="modal-body" class="modal-body">
        Are you sure you want to delete Supplier.
      </div>

      <!-- custom buttons -->
      <div slot="modal-footer" class="modal-footer">
        <button type="button" class="btn btn-default" @click="deleteSupplierModal = false">Cancel</button>
        <button type="button"  @click="deleteSupplier" class="btn btn-primary" >Yes</button>
      </div>
    </modal>
  </div>
</template>

<script>
  import { modal } from 'vue-strap'
  import Paginator from '../components/Paginator.vue'
  export default {
    name: 'suppliers',
    components: {
      Paginator,
      modal
    },
    data () {
      return {
        id: '',
        email: '',
        name: '',
        phone: '',
        address: '',
        abn: '',
        acn: '',
        suppliers: '',
        suppliersTasks: [], /* All tasks of all suppliers */
        selectedSuppliersTasks: [], /* All tasks of one/selected suppliers */
        deleteSupplierModal: false,
        deleteSupplierId: 0,
        paginationData: [],
        searchTxt: '',
        suppliersLoader: 0
      }
    },
    computed: {
    },
    created () {
      this.fetchSuppliers()
      this.fetchSupplierTasks()
    },
    methods: {
      getUrl (page) {
        if (this.searchTxt === '') {
          return process.env.API_URL + '/api/suppliers?page=' + page
        } else {
          return process.env.API_URL + '/api/suppliers?page=' + page + '&query=' + this.searchTxt
        }
      },
      setSelectedSuppliersTasks (tasks) {
        this.selectedSuppliersTasks = []
        tasks.forEach(task => {
          this.selectedSuppliersTasks.push(task.uuid)
        })
      },
      deleteSupplierOpenModal (supplier) {
        console.log(supplier.id)
        console.log('Delete Suppliers')
        this.deleteSupplierModal = true
        this.deleteSupplierId = supplier.id
      },
      deleteSupplier () {
        this.$http({
          url: process.env.API_URL + '/api/suppliers/' + this.deleteSupplierId,
          method: 'DELETE'
        }).then((res) => {
          this.resetData()
          this.fetchSuppliers()
          this.deleteSupplierModal = false
          this.$store.dispatch('setFlashMessage', {
            message: 'Supplier deleted successfully.',
            type: 'success'
          })
        })
      },
      editSupplier (supplier) {
        console.log(supplier.id)
        console.log('Edit Suppliers')
        this.id = supplier.id
        this.email = supplier.email
        this.name = supplier.name
        this.phone = supplier.phone
        this.address = supplier.address
        this.abn = supplier.abn
        this.acn = supplier.acn
        this.setSelectedSuppliersTasks(supplier.tasks)
      },
      fetchSupplierTasks () {
        this.$http({
          url: process.env.API_URL + '/api/suppliers/tasks',
          method: 'GET'
        }).then((res) => {
          if (res.status === 500) {
            this.fetchSupplierTasks()
          }
          this.suppliersTasks = res.data.data
        })
      },
      fetchSuppliers (page) {
        this.suppliersLoader = 1
        if (!page) {
          let query = location.search.match(/page=(\d+)/)
          page = query ? query[1] : 1
        }
        this.$http({
          url: this.getUrl(page),
          method: 'GET'
        }).then((res) => {
          if (res.status === 500) {
            this.fetchSuppliers(1)
          }
          this.suppliers = res.data.data
          this.paginationData = res.data.meta.pagination
          this.suppliersLoader = 0
        })
      },
      updateSupplier () {
        console.log('Update Suppliers')
        let data = this.getData()
        this.$http({
          url: process.env.API_URL + '/api/suppliers/' + this.id,
          method: 'PUT',
          data: data
        }).then((res) => {
          this.$store.dispatch('setFlashMessage', {
            message: 'Supplier updated successfully.',
            type: 'success'
          })
          this.resetData()
          this.fetchSuppliers()
        })
      },
      getData () {
        return {
          email: this.email,
          name: this.name,
          phone: this.phone,
          address: this.address,
          abn: this.abn,
          acn: this.acn,
          selectedSuppliersTasks: this.selectedSuppliersTasks
        }
      },
      resetData () {
        this.id = ''
        this.email = ''
        this.name = ''
        this.phone = ''
        this.address = ''
        this.abn = ''
        this.acn = ''
        this.selectedSuppliersTasks = []
        this.deleteSupplierId = 0
      },
      saveSupplier () {
        console.log('Saving supplier')
        let data = this.getData()
        this.$http({
          url: process.env.API_URL + '/api/suppliers',
          method: 'POST',
          data: data
        }).then((res) => {
          if (res.status === 200) {
            this.$store.dispatch('setFlashMessage', {
              message: 'Supplier added successfully.',
              type: 'success'
            })
            this.resetData()
            this.fetchSuppliers()
          }
        })
      }
    }
  }
</script>
<style lang="scss" scoped>

  .table > thead > tr > th,
  .table > thead > tr > td,
  .table > tbody > tr > th,
  .table > tbody > tr > td,
  .table > tfoot > tr > th,
  .table > tfoot > tr > td{
    border-top: 0px;
  }

</style>
