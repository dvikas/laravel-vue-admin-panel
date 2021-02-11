<template>

  <div class="container-fluid">
    <div class="row">
      <div class="faded-bg animated"></div>
      <div class="hidden-xs col-sm-7 col-md-8">
        <div class="clearfix">
          <div class="col-sm-12 col-md-10 col-md-offset-2">
            <div class="logo-title-container">
              <img class="img-responsive pull-left logo hidden-xs animated fadeIn"
                   src="~assets/img/house.svg" alt="Logo Icon">
              <div class="copy animated fadeIn">
                <h1>Builder Management</h1>
                <p>Welcome to All Renos backend.</p>
              </div>
            </div> <!-- .logo-title-container -->
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

        <div class="login-container">
          <div class="text-red text-center" v-if="(code && type) && loginErrorMsg === ''">
            <i class="fa fa-3x fa-spinner fa-spin"></i>
            <h4 >Verifying your authentication...</h4>
          </div>
          <div v-else>
            <div class="text-primary text-center " :class="loginLoader === true? 'add-login-loader' :'hide-login-loader'">
              <i class="fa fa-3x fa-spinner fa-spin"></i>
              <h4 >Verifying your authentication...</h4>
              <hr>
            </div>
            <div v-if="loginErrorMsg" class="alert alert-danger">{{ loginErrorMsg }}</div>
            <p>Sign In Below:</p>
            <form  v-on:submit.prevent="login">

              <div class="form-group form-group-default" id="emailGroup">
                <label>E-mail</label>
                <div class="controls">
                  <input v-model="data.body.username" :readonly="loginLoader" class="form-control" type="text"
                         placeholder="email@example.org" required>
                </div>
              </div>

              <div class="form-group form-group-default" id="passwordGroup">
                <label>Password</label>
                <div class="controls">
                  <input v-model="data.body.password" :readonly="loginLoader" type="password" placeholder="password"
                         class="form-control" required>
                </div>
              </div>

              <div style="margin-bottom:10px;">
                <small><a :href="apiUrl + '/password/reset'">Forgot password</a></small>
              </div>

              <div class="checkbox hide">
                <label>
                  <input type="checkbox" v-model="data.rememberMe" > &nbsp;Remember Me
                </label>
              </div>

              <button type="submit" class="btn btn-success btn-block" :disabled="loginLoader">
                <span class="signin">Login <i class="fa fa-long-arrow-right"></i></span>
              </button>

            </form>

            <div style="clear:both"></div>
            <hr>
            <button class="btn btn-google btn-block" v-on:click="social('google')"><i class="fa fa-google-plus"></i>&nbsp;Sign in with Google</button>


          </div>
        </div> <!-- .login-container -->

      </div> <!-- .login-sidebar -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->

</template>

<script>
  export default {

    data () {
      return {
        data: {
          body: {
            username: '',
            password: ''
          },
          rememberMe: false
        },
        error: null,
        context: 'oauth2 context',
        code: this.$route.query.code,
        type: this.$route.params.type,
        loginLoader: false,
        apiUrl: process.env.API_URL,
        loginErrorMsg: ''
      }
    },
    mounted () {
      if (this.$auth.redirect()) {
        console.log('Redirect from: ' + this.$auth.redirect().from.name)
      }
      // Can set query parameter here for auth redirect or just do it silently in login redirect.
      if (this.code) {
        this.$auth.oauth2({
          code: true,
          provider: this.type,
          url: process.env.API_URL + '/login/auth/google',
          params: {
            code: this.code,
            grant_type: 'social',
            client_id: process.env.CLIENT_ID,
            client_secret: process.env.CLIENT_SECRET,
            scope: process.env.SCOPE
          },
          success: function (res) {
            console.log('success ' + this.context)
          },
          error: function (res) {
            console.log(res)
            console.log('error ' + this.context)
            this.loginErrorMsg = 'Sorry, invalid google account.'
          }
        })
      }
    },
    methods: {
      jsonToQueryString (json) {
        return '' +
          Object.keys(json).map(function (key) {
            return encodeURIComponent(key) + '=' +
              encodeURIComponent(json[key])
          }).join('&')
      },
      login () {
        this.loginErrorMsg = ''
        let parameters = {
          grant_type: 'password',
          client_id: 3,
          client_secret: '0ytbxt6uTkOBHOCeHOn8nke0nKC9iU90xfhLKP94',
          // username: 'admin@admin.com',
          username: this.data.body.username,
          // password: 'password',
          password: this.data.body.password,
          scope: '*'
        }
        this.loginLoader = true
        // var redirect = this.$auth.redirect()
        this.$auth.login({
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Access-Control-Allow-Origin': '*'
          },
          data: this.jsonToQueryString(parameters),
          rememberMe: this.data.rememberMe,
          // redirect: {name: redirect ? redirect.from.name : 'Home'},
          success (res) {
            console.log('Auth Success')
            this.loginLoader = false
            // console.log('Token: ' + this.$auth.token())
            // console.log(res)
          },
          error (err) {
            if (err.response) {
              // The request was made, but the server responded with a status code
              // that falls out of the range of 2xx
              // console.log(err.response.status)
              // console.log(err.response.data)
              // console.log(err.response.headers)
              this.error = err.response.data
              this.loginErrorMsg = 'Invalid email/ password'
            } else {
              // Something happened in setting up the request that triggered an Error
              console.log('Error', err.message)
            }
            console.log(err.config)
            this.loginLoader = false
          }
        })
      },
      social (type) {
        this.$auth.oauth2({
          provider: type || this.type
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
  .is-title {
    text-transform: capitalize;
  }
  .add-login-loader {
    visibility: visible;
  }
  .hide-login-loader {
    visibility: hidden;
  }
</style>
