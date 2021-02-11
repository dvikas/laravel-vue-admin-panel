<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Project
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Projects</li>
      </ol>
    </section>
    <!--<pre>-->
      <!--{{ activeTab }}-->
      <!--tab2enabled {{ tab2enabled }} {{ typeof tab2enabled }}-->
      <!--tab3enabled {{ tab3enabled }} {{ typeof tab3enabled }}-->
      <!--tab4enabled {{ tab4enabled }} {{ typeof tab4enabled }}-->
      <!--tab5enabled {{ tab5enabled }} {{ typeof tab5enabled }}-->
      <!--tab6enabled {{ tab6enabled }} {{ typeof tab6enabled }}-->
    <!--</pre>-->
    <section class="content">

      <transition name="page" mode="out-in">
        <div>

          <div class="box box-info">

            <div class="box-body">
              <div class="col-xs-12 ">
                <tabs v-model="activeTab">

                  <tab header="Contact details" >
                    <div class="row">
                      <div class="col-sm-12">
                        <new-personal-details ></new-personal-details>
                      </div>
                    </div>
                  </tab>

                  <tab header="Client quoting" :disabled="tab2enabled === 0">
                    <add-project-details ></add-project-details>
                  </tab>

                  <tab header="Quote Acceptance" :disabled="tab3enabled === 0">
                    <project-summary ></project-summary>
                  </tab>

                  <tab header="Budgeting" :disabled="tab4enabled === 0">
                    <project-profit ></project-profit>
                  </tab>

                  <tab header="Project Variations" :disabled="tab5enabled === 0">
                    <project-variations ></project-variations>
                  </tab>

                  <tab header="Suppliers" :disabled="tab6enabled === 0">
                    <supplier-quote-invitation></supplier-quote-invitation>
                  </tab>

                </tabs>
              </div>

            </div>
            <!-- /.box-body -->

          </div>


        </div>
      </transition>
    </section>
  </div>
</template>

<script>

  import { tabs, tab } from 'vue-strap'
  import NewPersonalDetails from './partials/CustomerContactDetails'
  import AddProjectDetails from './partials/client-quoting/ClientQuoting'
  import ProjectSummary from './partials/quote-acceptance/project-summary.vue'
  import ProjectProfit from './partials/ProjectProfit'
  import ProjectVariations from './partials/ProjectVariations'
  import SupplierQuoteInvitation from './partials/SupplierQuoteInvitation'

  export default {

    name: 'add-project',

    components: {
      SupplierQuoteInvitation,
      ProjectVariations,
      ProjectSummary,
      NewPersonalDetails,
      AddProjectDetails,
      ProjectProfit,
      alert,
      tabs,
      tab
    },

    computed: {
      activeTab: {
        get: function () {
          return this.$store.getters.getActiveTab
        },
        // setter
        set: function (newValue) {
          console.log('I am i setter of activeTab' + newValue)
          this.$store.commit('setActiveTab', newValue)
        }
      },
      tab2enabled () {
        return parseInt(this.$store.getters.getIsTab2enabled)
      },
      tab3enabled () {
        return parseInt(this.$store.getters.getIsTab3enabled)
      },
      tab4enabled () {
        return parseInt(this.$store.getters.getIsTab4enabled)
      },
      tab5enabled () {
        return parseInt(this.$store.getters.getIsTab5enabled)
      },
      tab6enabled () {
        return parseInt(this.$store.getters.getIsTab6enabled)
      }
    },

    data () {
      return {
      }
    },

    created () {
      if (this.$route.query.project === 'show') {
        this.$store.commit('setActiveTab', 0)
      }
    },

    methods: {
    }
//    watch: {
//      tab2enabled (val) {
//        this.tab2enabled = val
//      },
//      tab3enabled (val) {
//        this.tab3enabled = val
//      },
//      tab4enabled (val) {
//        this.tab4enabled = val
//      },
//      tab5enabled (val) {
//        this.tab5enabled = val
//      },
//      tab6enabled (val) {
//        this.tab6enabled = val
//      }
//    }
  }

</script>
