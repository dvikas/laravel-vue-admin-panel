<template>
  <div >
    <section class="content-header">
      <h1>All Projects</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Projects</li>
      </ol>
    </section>
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-xs-12">
          <!-- TABLE: LATEST PROJECTS -->
          <div class="box box-info">
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row" style="margin-bottom: 10px;">
                  <div class="col-sm-6">&nbsp;</div>
                  <div class="col-sm-6">
                    <div class="pull-right">
                      <input class="form-control input-sm" placeholder="Search"
                             v-model="searchTxt" type="search">
                      <button @click="fetchProjects" class="btn btn-sm btn-default">
                        <i class="fa fa-search"></i></button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                           aria-describedby="example1_info">
                      <thead>
                      <tr>
                        <th>Project ID</th>
                        <th>Customer</th>
                        <th>Project Type</th>
                        <th>Property Type</th>
                        <th>Date</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr v-for="(project, index) in projects">
                        <td>
                          <router-link tag="td" :to="{ path: '/projects/index/' + project.customer.uuid + '/' + project.id+ '?project=show'} " :query="{ page: '1' }">
                            <a href="#">{{ project.slug }}</a>
                          </router-link>
                        </td>
                        <td>{{ project.customer.name | capitalize  }}</td>
                        <td>{{ project.project_type | capitalize }}</td>
                        <td>
                          <span v-if="project.property_type === 'owner_occupier'">Owner Occupier</span>
                          <span v-else>Investment</span>
                        </td>
                        <td>{{ project.created_at }}</td>
                        <td>
                          <span class="label label-success" v-if="parseInt(project.status) === 1">Completed</span>
                          <span class="label label-warning" v-else >Pending</span>
                        </td>
                        <td><button @click="deleteProjectModel(index)" type="button" title="Delete Project" class="btn btn-danger btn-xs "><i class="fa fa-trash-o "></i> Delete</button></td>
                      </tr>

                      <!--<tr v-if="projects.length === 0">-->
                        <!--<td colspan="7" class="text-danger">Project not found. Please-->
                          <!--<router-link exact tag="a" :to="{ path: '/new-project'}">click here</router-link>-->
                          <!--to add new project.</td>-->
                      <!--</tr>-->

                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 text-center">
                    <paginator :dataSet="paginationData" @updatePaginate="fetchProjects"></paginator>
                  </div>
                </div>
              </div>

              <div v-if="projectLoader === 1 && projects.length === 0" class="alert alert-info">
                <i class="fa fa-refresh fa-spin"></i> Loading&hellip;
              </div>
              <div v-if="projectLoader === 0 && projects.length === 0" class="alert alert-danger">
                <i class="fa fa-info-circle"></i> Sorry, project not found!
              </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>

    <modal v-model="deleteProjectModal" effect="fade" v-if="projects[selectedIndex] !== undefined">
      <div slot="modal-header" class="modal-header">
        <h4 class="modal-title">
          <b>Project</b>
        </h4>
      </div>
      <div slot="modal-body" class="modal-body">
        Are you sure you want to delete project <strong>"{{ projects[selectedIndex].slug }}"</strong> ?
      </div>

      <!-- custom buttons -->
      <div slot="modal-footer" class="modal-footer">
        <button type="button" class="btn btn-default" @click="deleteProjectModal = false">Cancel</button>
        <button type="button" @click="deleteProject" class="btn btn-primary" >Yes</button>
      </div>
    </modal>
    <!--<pre>{{ projects }}</pre>-->
  </div>
</template>

<script>
  import Paginator from '../components/Paginator.vue'
  import { modal } from 'vue-strap'

  export default {
    components: {
      Paginator, modal
    },
    data () {
      return {
        projects: [],
        paginationData: [],
        searchTxt: '',
        deleteProjectModal: false,
        selectedIndex: 0,
        projectLoader: 0
      }
    },
    created () {
      this.fetchProjects()
    },
    computed: {
      projectName () {
        return this.projects[this.selectedIndex].id
      }
    },

    methods: {

      deleteProject () {
        console.log(this.selectedIndex)
        const index = this.selectedIndex
        const id = this.projects[index].id
        this.$http({
          url: process.env.API_URL + '/api/projects/' + id,
          method: 'DELETE'
        }).then((res) => {
          this.projects.splice(index, 1)
          this.deleteProjectModal = false
          this.$store.dispatch('setFlashMessage', {
            message: 'Project deleted successfully.',
            type: 'success'
          })
        })
      },

      deleteProjectModel (index) {
        this.selectedIndex = index
        this.deleteProjectModal = true
      },

      getUrl (page) {
        if (this.searchTxt === '') {
          return process.env.API_URL + '/api/projects?page=' + page
        } else {
          return process.env.API_URL + '/api/projects?page=' + page + '&query=' + this.searchTxt
        }
      },

      fetchProjects (page) {
        this.projectLoader = 1
        if (!page) {
          let query = location.search.match(/page=(\d+)/)
          page = query ? query[1] : 1
        }
        this.$http({
          url: this.getUrl(page),
          method: 'GET'
        }).then((res) => {
          if (res.status === 500) {
            this.fetchProjects(1)
          }
          this.projects = res.data.data
          this.paginationData = res.data.meta.pagination
          this.projectLoader = 0
        })
      }
    },
    filters: {
      capitalize: function (value) {
        if (!value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
      }
    }
  }
</script>
