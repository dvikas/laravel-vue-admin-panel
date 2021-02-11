<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
      </h1>
      <ol class="breadcrumb">
        <!--<li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>-->
        <router-link exact tag="li" :to="{ path: '/'}">
          <a href="#"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
        </router-link>
        <li class="active">Profile</li>
      </ol>
    </section>

    <section class="content">

      <div class="row">
        <div class="col-sm-8">
          <div class="box box-info ">
            <!-- /.box-header -->
            <div class="box-body">
              <form autocomplete="off" v-on:submit.prevent="updateProfile()" >

                <div class="form-group col-sm-6">
                  <label>Email</label>
                  <input type="text" disabled class="form-control" v-model="email">
                </div>

                <div class="form-group col-sm-6">
                  <label for="userNameId">Name</label>
                  <input type="text" required class="form-control" id="userNameId" v-model="uname"
                         placeholder="Name" name="uname" >
                </div>

                <div class="form-group col-sm-6" >
                  <label for="phoneId">Phone</label>
                  <input type="text" required class="form-control" id="phoneId" v-model="phone"
                         placeholder="Phone" name="phone" >
                </div>

                <div class="form-group col-sm-6">
                  <label for="phoneId">Address</label>
                  <textarea required class="form-control" id="addressId" v-model="address"
                            placeholder="Address" name="address"></textarea>
                </div>

                <div class="form-group col-sm-6">

                  <div class="row">
                    <div class="col-sm-6">&nbsp;
                      <label >Profile Picture</label><br>
                      <image-upload @fileLoaded="updateProfilePic"></image-upload>
                    </div>

                    <div class="col-sm-4">
                      <div class="thumbnail1">
                        <img :src="src" class="img img-responsive">
                      </div>
                    </div>
                  </div>

                  <p v-if="imageError" class="text-danger">
                    Please upload valid image(jpg, jpeg or png)</p>
                </div>
                <!--<div class="row">-->
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary ">Update Profile</button>
                  </div>
                <!--</div>-->

              </form>
              <!--<button @click="me">GET DETAILS</button>-->

            </div>
            <!-- /.box-body -->
          </div>
          <!--<pre>{{ suppliers }}</pre>-->
          <!--<pre>{{ tasks }}</pre>-->
          <!--<pre>{{ selectedSuppliersTasks }}</pre>-->
          <!--<pre>{{ suppliersTasks }}</pre>-->
          <!-- /.box -->
        </div>
        <div class="col-sm-4">
          <div class="box box-info">
            <div class="box-body">
              <h4>Change Password</h4>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form autocomplete="off" v-on:submit.prevent="updatePassword()">

                <!--  fake fields are a workaround for chrome/opera autofill getting the wrong fields -->
                <input id="username" style="display:none" type="text" name="fakeusernameremembered">
                <input id="password" style="display:none" type="password" name="fakepasswordremembered">
                <div class="form-group">
                  <label for="currentPasswordId">Current Password</label>
                  <input type="password" required class="form-control" id="currentPasswordId" v-model="password"
                         placeholder="Current Password" name="current_password" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="newPasswordId">New Password</label>
                  <input type="password" required class="form-control" id="newPasswordId" v-model="newPassword"
                         placeholder="New Password">
                </div>
                <div class="form-group">
                  <label for="confirmPasswordId">Confirm Password</label>
                  <input type="password" required class="form-control" id="confirmPasswordId"
                         placeholder="Confirm Password" v-model="confirmPassword">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <!--<pre>-->
                <!--{{ $auth.user().name }}-->

      <!--</pre>-->
    </section>
  </div>
</template>

<script>
  import ImageUpload from '../projects/partials/ImageUpload'

  export default {
    name: 'profile',

    components: {
      ImageUpload
    },

    data () {
      return {
        uname: this.$auth.user().name,
        password: '',
        newPassword: '',
        confirmPassword: '',
        email: this.$auth.user().email,
        phone: this.$auth.user().phone,
        address: this.$auth.user().address,
        serverUrl: process.env.API_URL,
        imageError: ''
      }
    },

    computed: {
      src () {
        return this.serverUrl + '/storage/' + this.$auth.user().avatar
      },
      user () {
        return this.$auth.user()
      }
    },

    methods: {
      updateProfile () {
        this.$http({
          url: this.serverUrl + '/api/me',
          method: 'PUT',
          data: {
            name: this.uname,
            phone: this.phone,
            address: this.address
          }
        }).then((res) => {
          if (res.status === 200) {
            this.$auth.user(res.data.data)
            this.$store.dispatch('setFlashMessage', {
              message: 'Profile updated successfully.',
              type: 'success'
            })
          }
        })
      },
      updatePassword () {
        this.$http({
          url: this.serverUrl + '/api/me/password',
          method: 'PUT',
          data: {
            current_password: this.password,
            password: this.newPassword,
            password_confirmation: this.confirmPassword
          }
        }).then((res) => {
          if (res.status === 200) {
            this.$auth.user(res.data.data)
            this.$store.dispatch('setFlashMessage', {
              message: 'Password changed successfully.',
              type: 'success'
            })
          }
        })
      },
      me () {
        this.$http({
          url: this.serverUrl + '/api/me',
          method: 'GET'
        }).then((res) => {
        })
      },
      updateProfilePic (imageData) {
//        console.log(imageData)
        this.src = imageData.src
//        let fileName = imageData.fileName
        let file = imageData.file
//        let category = imageData.category
        let data = new window.FormData()
        data.append('avatar', file)
        let that = this
        this.$http({
          url: this.serverUrl + '/api/me/profile/image',
          method: 'POST',
          data: data
        }).then((response) => {
//          console.log(response)
          this.$auth.user().avatar = response.data.data.avatar
        }, function (error) {
//          console.log(error.response.data.message)
          that.imageError = (error.response.data.message)
        })
      }
    }
  }

</script>
