<template>
  <div>
    <section class="content-header">
      <h1>All Users</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-sm-8 ">
          <!-- TABLE: LATEST PROJECTS -->
          <div class="box box-info ">
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                  <div class="col-sm-6"></div>
                  <div class="col-sm-6">
                    <div class="pull-right">
                        <input class="form-control input-sm" placeholder="Search"
                              v-model="searchTxt" type="search">
                      <button @click="fetchUsers(1)" class="btn btn-sm btn-default">
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
                        <!--<th>Phone</th>-->
                        <!--<th>Address</th>-->
                        <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody v-for="(user, index) in users">

                      <tr :class=" index % 2 !== 0 ? 'active' :''">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <!--<td>{{ user.phone }}</td>-->
                        <!--<td>{{ user.address }}</td>-->
                        <td v-if="user.email !== $auth.user().email">
                          <!--<a href="javascript:void(0)" title="Edit"-->
                             <!--v-on:click.prevent="editUser(user)"><i class="fa fa-edit"></i></a>&nbsp;-->
                          <a href="javascript:void(0)" title="Delete" class="btn btn-danger btn-xs"
                             v-on:click.prevent="deleteUserOpenModal(user)"><i
                            class="fa fa-trash"></i> Delete</a>
                        </td>
                        <td v-else>
                          <code>---</code>
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
                    <paginator :dataSet="paginationData" @updatePaginate="fetchUsers"></paginator>
                  </div>
                </div>
              </div>

              <div v-if="usersLoader === 1 && users.length === 0" class="alert alert-info">
                <i class="fa fa-refresh fa-spin"></i> Loading&hellip;
              </div>
              <div v-if="usersLoader === 0 && users.length === 0" class="alert alert-danger">
                <i class="fa fa-info-circle"></i> Sorry, users not found!
              </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!--<pre>{{ errors }}</pre>-->
          <!--<pre>{{ tasks }}</pre>-->
          <!--<pre>{{ suppliersTasks }}</pre>-->
          <!-- /.box -->
        </div>
        <div class="col-xs-4">
          <div class="box box-info">
            <div class="box-body">
              <h4 v-if="id === ''">Add new user</h4>
              <h4 v-else>Edit user</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form v-on:submit.prevent="id === '' ? saveUser() : updateUser()">
                <div class="form-group">
                  <label for="supplierNameId">Name</label>
                  <input type="text" required class="form-control" id="supplierNameId" v-model="name"
                         placeholder="Name">
                </div>
                <div class="form-group" :class="{'has-error': emailError !== ''}">
                  <label for="supplierEmailId">Email address</label>
                  <input type="email" required class="form-control" id="supplierEmailId" v-model="email"
                         placeholder="Email" name="email">
                  <span>{{ errors.first('email') }}</span>
                  <span class="text-danger" v-if="emailError">{{ emailError }}</span>
                </div>

                <div class="form-group" :class="{'has-error': passwordError !== ''}">
                  <label for="passwordId">Password</label>
                  <input type="password" required class="form-control" id="passwordId" v-model="password"
                         placeholder="Password" name="password">
                  <span class="text-danger" v-if="passwordError">{{ passwordError }}</span>
                </div>
                <!--<div class="form-group">-->
                  <!--<label for="supplierPhoneId">Phone</label>-->
                  <!--<input type="text" required class="form-control" id="supplierPhoneId" v-model="phone"-->
                         <!--placeholder="Phone">-->
                <!--</div>-->
                <!--<div class="form-group">-->
                  <!--<label for="supplierAddressId">Address</label>-->
                <!--<textarea required class="form-control" id="supplierAddressId" v-model="address"-->
                          <!--placeholder="Address"></textarea>-->
                <!--</div>-->

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

    <modal v-model="deleteUserModal" effect="fade">
      <div slot="modal-header" class="modal-header">
        <h4 class="modal-title">
          <b>Delete</b>
        </h4>
      </div>
      <div slot="modal-body" class="modal-body">
        Are you sure you want to delete user.
      </div>

      <!-- custom buttons -->
      <div slot="modal-footer" class="modal-footer">
        <button type="button" class="btn btn-default" @click="deleteUserModal = false">Cancel</button>
        <button type="button"  @click="deleteUser" class="btn btn-primary" >Yes</button>
      </div>
    </modal>
  </div>
</template>

<script>
  import Vue from 'vue'
  import VeeValidate from 'vee-validate'
  Vue.use(VeeValidate)
  import { modal } from 'vue-strap'
  import Paginator from '../components/Paginator.vue'
  export default {
    name: 'users',
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
        password: '',
        deleteUserModal: false,
        deleteUserId: 0,
        paginationData: [],
        users: [],
        searchTxt: '',
        usersLoader: 0,
        emailError: '',
        passwordError: ''
      }
    },
    computed: {
    },
    created () {
      this.fetchUsers()
    },
    methods: {
      getUrl (page) {
        if (this.searchTxt === '') {
          return process.env.API_URL + '/api/users?page=' + page
        } else {
          return process.env.API_URL + '/api/users?page=' + page + '&query=' + this.searchTxt
        }
      },
      deleteUserOpenModal (user) {
        console.log(user.id)
        console.log('Delete users')
        this.deleteUserModal = true
        this.deleteUserId = user.id
      },
      deleteUser () {
        this.$http({
          url: process.env.API_URL + '/api/users/' + this.deleteUserId,
          method: 'DELETE'
        }).then((res) => {
          this.$store.dispatch('setFlashMessage', {
            message: 'User deleted successfully.',
            type: 'success'
          })
          this.resetData()
          this.fetchUsers()
          this.deleteUserModal = false
        })
      },
      editUser (user) {
        console.log(user.id)
        console.log('Edit users')
        this.id = user.id
        this.email = user.email
        this.name = user.name
        this.phone = user.phone
        this.address = user.address
      },
      fetchUsers (page) {
        this.usersLoader = 1
        if (!page) {
          let query = location.search.match(/page=(\d+)/)
          page = query ? query[1] : 1
        }
        console.log(page)
        this.$http({
          url: this.getUrl(page),
          method: 'GET'
        }).then((res) => {
          if (res.status === 500) {
            this.fetchUsers(1)
          }
          this.users = res.data.data
          this.paginationData = res.data.meta.pagination
          this.usersLoader = 0
        })
      },
      updateUser () {
        console.log('Update users')
        let data = this.getData()
        this.$http({
          url: process.env.API_URL + '/api/users/' + this.id,
          method: 'PUT',
          data: data
        }).then((res) => {
          this.resetData()
          this.fetchUsers()
        })
      },
      getData () {
        let role = '96eb8fd0-49ed-11e8-8d0f-65403c1db0ec'
        return {
          email: this.email,
          name: this.name,
          password: this.password,
          password_confirmation: this.password,
          roles: [role]
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
        this.deleteUserId = 0
      },
      saveUser () {
        console.log('Saving user')
        this.emailError = ''
        this.passwordError = ''
        let data = this.getData()
        this.$http({
          url: process.env.API_URL + '/api/users',
          method: 'POST',
          data: data
        }).then((res) => {
          console.log(res.data.errors)
          if (res.status === 201) {
            this.resetData()
            this.fetchUsers()
            this.$store.dispatch('setFlashMessage', {
              message: 'User added successfully.',
              type: 'success'
            })
          } else {
            console.log('I am in else')
          }
        },
        (err) => {
          if (err.response.data.errors.email) {
            this.emailError = err.response.data.errors.email[0]
          }
          if (err.response.data.errors.password) {
            this.passwordError = err.response.data.errors.password[0]
          }
          console.log('Err', err)
        })
        .catch((e) => {
          console.log('Caught', e)
        })
      }
    }
  }
</script>
<style lang="scss" scoped>

</style>
