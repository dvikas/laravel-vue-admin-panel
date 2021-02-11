<template>

    <div >
      <div v-if="isLoading === true">
        <i class="fa fa-spinner fa-spin"></i> loading&hellip;
      </div>
      <div class="box box-info" v-else>
          <!--<div class="box-header"></div>-->
          <div class="box-body">
              <form enctype="multipart/form-data">
                  <div class="form-group">
                      <label ><strong>Confirmation Email received from customer?</strong></label><br>
                      <label class="radio-inline">
                          <input type="radio" name="emailReceived" :disabled= "id !== ''"
                                 v-model="emailReceived" value="1"> Yes
                      </label>
                      <label class="radio-inline">
                          <input type="radio" name="emailReceived" :disabled= "id !== ''"
                                 v-model="emailReceived" value="0"> No
                      </label>
                  </div>
                  <div class="form-group">
                      <label ><strong>Amount received from the customer?</strong></label><br>
                      <label class="radio-inline">
                          <input type="radio" name="amountReceived" :disabled= "id !== ''"
                                 v-model="amountReceived" value="1"> Yes
                      </label>
                      <label class="radio-inline">
                          <input type="radio" name="amountReceived" :disabled= "id !== ''"
                                 v-model="amountReceived" value="0"> No
                      </label>
                  </div>
                  <div class="form-group" :class="{'has-error': amountReceived === '1'  && paymentDetails === ''}">
                      <label for="paymentDetailsId"><strong>Payment Details</strong></label>
                      <textarea  class="form-control" v-model="paymentDetails"
                                 v-validate="'required'" :disabled= "id !== ''"
                                 id="paymentDetailsId" placeholder="Payment Details"></textarea>
                  </div>
                  <div class="form-group" :class="{'has-error': amountReceived === '1' && document === ''}">
                    <label v-if = "id === ''"><strong>Upload Document</strong></label>
                    <image-upload v-if = "id === ''" file-name="document" key1="-1" key2="-1"
                                  category="other" @fileLoaded="afterImageLoaded"></image-upload>
                    <a v-if="document" :href="serverUrl +'/storage/' + document" target="_blank"><i class="fa fa-paperclip"></i>&nbsp;View document</a>
                  </div>

                <div class="row">
                  <div class="col-sm-6">
                    <button type="button" :disabled="parseInt(amountReceived) === 0 || (document === '' || paymentDetails === '')"
                            @click="saveProjectQuote" v-if = "id === ''"
                            class="btn btn-success btn-lg"> Job won !! <i class="fa fa-thumbs-o-up"></i></button>
                    <h4 class="text-success" v-if="acceptedDate">Job won on: <label class="label label-success">{{ acceptedDate }}</label></h4>
                  </div>
                  <div class="col-sm-6">
                    <a type="button "
                       :href="serverUrl + '/invoice/' + projectId + '/' + $auth.user().id"
                       class="btn btn-default  pull-right"> <i class="fa fa-file-pdf-o"></i> View Invoice</a>
                    &nbsp;
                    <button type="button" style="margin-right:10px;" @click="sendInvoice" class="btn btn-default pull-right">
                      <i class="fa fa-envelope-o"></i> Send invoice to customer</button>
                  </div>
                </div>


              </form>
          </div>
      </div>
      <!--<pre>-->
        <!--{{ document }}-->
        <!--{{ paymentDetails }}-->
        <!--{{ amountReceived }}-->
        <!--{{ emailReceived }}-->
        <!--{{ customerId }}-->
        <!--{{ projectId }}-->
      <!--</pre>-->
    </div>
</template>

<script>
  import ImageUpload from '../ImageUpload'
//  import VeeValidate from 'vee-validate'
//  import Vue from 'vue'
//  Vue.use(VeeValidate)

  export default {
    name: 'project-summary',
    components: {
      ImageUpload
    },
    props: ['tab3data'],
    data () {
      return {
        id: '',
        document: '',
        paymentDetails: '',
        amountReceived: 0,
        emailReceived: 0,
        customerId: this.$route.params.customerId,
        projectId: this.$route.params.projectId,
        serverUrl: process.env.API_URL,
        acceptedDate: '',
        isLoading: false
//        projectStatus: 0
      }
    },
    created () {
//      if (this.activeTab === 2) {
//        this.getProjectQuote()
//      }
    },
    computed: {
      activeTab () {
        return this.$store.getters.getActiveTab
      },
      projectStatus () {
        return this.$store.getters.getProjectStatus
      }
    },
    mounted () {
    },
    methods: {
      sendInvoice () {
        this.$http({
          url: process.env.API_URL + '/api/projects/invoice/' + this.projectId,
          method: 'GET'
        }).then((res) => {
          this.$store.dispatch('setFlashMessage', {
            message: 'Invoice sent successfully.',
            type: 'success'
          })
        })
      },

      afterImageLoaded (imageData) {
        let fileName = imageData.fileName
        let file = imageData.file
        let category = imageData.category
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
          this.document = res.data.path
        })
      },

      saveProjectQuote () {
//        var scope = 'quotes'
//        this.$validator.validateAll(scope).then((result) => {
//          if (result) {
        this.$http({
          url: this.serverUrl + '/api/projects/quotes/' + this.projectId,
          method: 'POST',
          data: {
            document: this.document,
            payment_details: this.paymentDetails,
            amount_received: this.amountReceived,
            email_received: this.emailReceived
          }
        }).then((res) => {
          if (res.status === 200) {
            this.id = res.data.id
            this.acceptedDate = res.data.accepted_date
            this.$store.commit('setProjectStatus', 1)
            this.$store.commit('setIsTab4enabled', 1)
            this.$store.commit('setIsTab5enabled', 1)
            this.$store.commit('setIsTab6enabled', 1)
            this.$store.dispatch('setFlashMessage', {
              message: 'Job won successfully.',
              type: 'success'
            })
          }
        })
//          }
//        })
      },

      getProjectQuote () {
        if (this.projectId !== undefined) {
          this.isLoading = true
          this.$http({
            url: process.env.API_URL + '/api/projects/quotes/' + this.projectId,
            method: 'GET'
          }).then((res) => {
            if (res.status === 500) {
              this.getProjectQuote()
            } else if (res.status === 200) {
              this.id = res.data.data.id
              this.document = res.data.data.document
              this.paymentDetails = res.data.data.payment_details
              this.amountReceived = res.data.data.amount_received
              this.emailReceived = res.data.data.email_received
              this.acceptedDate = res.data.data.accepted_date
              this.isLoading = false
            }
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
      activeTab (newValue) {
        if (newValue === 2 && this.projectStatus === 1) {
          this.getProjectQuote()
        }
      }
//      projectStatus (newValue) {
//        this.projectStatus = newValue
//      }
    }
  }

</script>

<style lang="scss" scoped>

</style>
