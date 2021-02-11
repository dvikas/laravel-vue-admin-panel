<template>
  <div >
    <div class="row ">

      <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('uname') }">

        <label for="nameId">Name</label>
        <input type="text" v-validate="'required'" name="uname" v-model="uname"
               class="form-control" placeholder="Name" id="nameId">
      </div>

      <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('email') }">
        <label for="emailId">Email address</label>
        <input type="email" v-validate="'required|email'" name="email" v-model="email"
               class="form-control col-xs-6" id="emailId" placeholder="Email">
      </div>

      <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('phone') }">
        <label for="phoneId">Phone</label>
        <input type="email" v-validate="'required'" name="phone" v-model="phone"
               class="form-control col-xs-6" id="phoneId" placeholder="Phone">
      </div>


    </div>

    <label class="label-uppercase text-muted">Home Address</label>
    <div class="border-top">
      <div class="row">

        <div class="form-group col-xs-12  col-sm-6" :class="{'has-error': errors.has('address') }">
          <textarea class="form-control" id="streetId" v-validate="'required'" name="address"
                    v-model="address" placeholder="Address"></textarea>
        </div>
        <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('postal_code') }">
          <label for="postalId1">Postal Code</label>
          <input type="text" id="postalId1" class="form-control" name="postal_code" v-model="postal_code"
                 placeholder="Postal address" v-validate="'required'" />
        </div>
        <div class="form-group col-xs-12  col-sm-3">
          <label for="postalId1">Country</label>
          <select class="form-control">
            <option>Australia</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('project_type')}" >
        <label for="projectTypeId">Project type</label>

        <select name="project_type" id="projectTypeId" v-validate="'required'"
                v-model="project_type" class="form-control">
          <option value="">-Select Project Type-</option>
          <option value="new">New</option>
          <option value="renovation">Renovation</option>
          <option value="extension">Extension</option>
        </select>
      </div>

      <div class="form-group col-xs-12 col-sm-6">
        <!--<div class="form-group col-xs-12 col-sm-4">-->
        <!--<label  style="width:100%;">Family Details</label>-->
        <!--<span>-->
            <!--<checkbox  class="checkbox-inline col-xs-6" v-model="typeOfUse.family"-->
                       <!--true-value="family" type="success">Family</checkbox>-->
            <!--</span>-->
        <!--<span>-->
            <!--<checkbox  class="checkbox-inline col-xs-6" v-model="typeOfUse.children"-->
                       <!--true-value="children" type="success">children</checkbox>-->
          <!--</span>-->
        <!--</div>-->
      <!--</div>-->
      <!--<div class="col-xs-12 col-sm-3">-->
        <div class="form-group col-xs-6 col-sm-4">
          <label for="noOfChild">Children</label>
          <input type="text" id="noOfChild" class="form-control" name="number_children"
                 v-model="number_children" maxlength="2" placeholder="Children" />
        </div>
        <div class="form-group col-xs-6 col-sm-4">
          <label for="noOfChild">Family Members</label>
          <input type="text" id="noOfFamily" class="form-control" name="number_family"
                 v-model="number_family" maxlength="2" placeholder="Family Members" />
        </div>
      </div>


      <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('property_type')}" >
        <label for="propertyTypeId">Property type</label>
        <select name="property_type" id="propertyTypeId" v-validate="'required'"
                v-model="property_type" class="form-control">
          <option value="">-Select Property Type-</option>
          <option value="investment">Investment</option>
          <option value="owner_occupier">Owner Occupier</option>
        </select>
      </div>
    </div>

    <label class="label-uppercase text-muted">Site Address</label>
    <div class="border-top">
      <div class="row">
        <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('site_block')}">
          <label for="blockId2">Block</label>
          <input type="text" v-model="site_block" name="site_block" class="form-control"
                 id="blockId2" placeholder="Block" v-validate="'required'">
        </div>

        <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('site_section')}">
          <label for="sectionId2">Section</label>
          <input type="text" v-model="site_section" class="form-control" name="site_section"
                 id="sectionId2" placeholder="Section" v-validate="'required'">
        </div>

        <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('site_suburb')}">
          <label for="suberbId2">Suburb</label>
          <input v-model="site_suburb" type="text" class="form-control" id="suberbId2"
                 placeholder="Suburb" name="site_suburb" v-validate="'required'">
        </div>

        <div class="form-group col-xs-12 col-sm-3" :class="{'has-error': errors.has('site_postal_code')}">
          <label for="postalId2">Postal Code</label>
          <input type="text" id="postalId2" name="site_postal_code" class="form-control"
                 v-model="site_postal_code"  placeholder="Postal address" v-validate="'required'"/>
        </div>

      </div>

    </div>
    <div class="border-top">
<!--<pre>{{ errors }}</pre>-->
      <button type="submit"  @click="validateForm1" class="btn btn-primary pull-right">Save</button>
    </div>

  </div>
</template>

<script>

  import { checkbox, radio } from 'vue-strap'
  import Vue from 'vue'
  import VeeValidate from 'vee-validate'
  Vue.use(VeeValidate)

  export default {
    name: 'new-personal-details',
    components: {
      checkbox,
      radio
    },
    data () {
      return {
        uname: '',
        email: '',
        phone: '',
        address: '',
        postal_code: '',
        project_type: '',
        typeOfUse: ['children', 'family'],
        number_children: '',
        number_family: '',
        property_type: '',
        site_postal_code: '',
        site_suburb: '',
        site_section: '',
        site_block: ''
      }
    },
    created () {
      this.getContactDetails()
      // this.setContactDetails()
    },
    computed: {
      editContactDetails () {
        return this.$store.getters.getCustomerDetails
      },
      projectStatus () {
        return this.$store.getters.getProjectStatus
      }
    },
    watch: {
      'editContactDetails': function () {
        var customerId = this.$route.params.customerId
        if (customerId) {
          this.setContactDetails()
        }
      }
    },
    methods: {
      activateTab (tab) {
        this.$emit('clicked-show-tab', tab)
      },
      getContactDetails () {
        var customerId = this.$route.params.customerId
        if (customerId) {
          this.$store.dispatch('getContactDetails', customerId).then((res) => {
//            let data = this.$store.getters.getCustomerDetails
//            console.log('I am in getContactDetails')
//            if (data.name === undefined) {
//              this.$store.dispatch('getContactDetails', customerId)
//            }
          })
        } else {
          this.$store.commit('setActiveTab', 0)
          this.$store.commit('setIsTab2enabled', 0)
          this.$store.commit('setIsTab3enabled', 0)
          this.$store.commit('setIsTab4enabled', 0)
          this.$store.commit('setIsTab5enabled', 0)
          this.$store.commit('setIsTab6enabled', 0)
        }
      },
      setContactDetails () {
        var data = this.$store.getters.getCustomerDetails
        this.uname = data.name
        this.email = data.email
        this.phone = data.phone
        this.postal_code = data.postal_code
        this.address = data.address
        this.number_family = data.family_members
        this.number_children = data.children
        this.site_postal_code = data.project_details.postal_code
        this.site_block = data.project_details.block
        this.site_section = data.project_details.section
        this.site_suburb = data.project_details.suburb
        this.project_type = data.project_details.project_type
        this.property_type = data.project_details.property_type
      },
      validateForm1 () {
        this.$validator.validateAll().then((result) => {
          if (result) {
            var data = {
              'name': this.uname,
              'phone': this.phone,
              'email': this.email,
              'postal_code': this.postal_code,
              'address': this.address,
              'is_children': this.typeOfUse.children === 'children' ? 1 : 0,
              'is_family': this.typeOfUse.family === 'family' ? 1 : 0,
              'family_members': this.number_family,
              'children': this.number_children,
              'site_postal_code': this.site_postal_code,
              'site_block': this.site_block,
              'site_section': this.site_section,
              'site_suburb': this.site_suburb,
              'project_type': this.project_type,
              'property_type': this.property_type
            }
            console.log(data)
            if (this.$route.params.customerId) {
              data.id = this.$route.params.customerId
              this.$store.dispatch('updateContactDetails', data).then(() => {
                this.$store.commit('setIsTab2enabled', 1)
                this.$store.commit('setActiveTab', 1)
                this.$store.dispatch('setFlashMessage', {
//                  title: 'Contact details updated',
                  message: 'Contact details updated',
                  type: 'success'
                })
              })
            } else {
              this.$store.dispatch('saveContactDetails', data).then((res) => {
//                this.$store.commit('setCustomerId', res.data.data.id)
//                var customerId = this.$store.getters.getCustomerId
                this.$store.commit('setIsTab2enabled', 1)
                this.$store.commit('setActiveTab', 1)
                var projectId = res.data.data.project_details.id
                this.$router.push({name: 'ShowProject', params: {customerId: res.data.data.id, projectId: projectId}})
                this.$store.dispatch('setFlashMessage', {
//                  title: 'Contact details added',
                  message: 'Contact details added',
                  type: 'success'
                })
              })
            }
          }
        })
      }
    }
  }
</script>

<style scoped>

</style>
