<template>
    <div style="display: inline-block;" class="form-group" v-if="filePath">
        <input type="file" name="avatar" @change="onChange" >
    </div>
    <div style="display: inline-block;" class="form-group" :class="{'has-error': errors.has('avatar')}" v-else>
        <input type="file" name="avatar" @change="onChange" v-validate="'required'">
    </div>
</template>

<script>
  import Vue from 'vue'
  import VeeValidate from 'vee-validate'
  Vue.use(VeeValidate)

  export default {
    name: 'image-upload',
    props: ['fileName', 'category', 'key1', 'key2', 'doCheckFileError', 'filePath'],
    methods: {
      onChange (e) {
        if (!e.target.files.length) return

        let file = e.target.files[0]
        let reader = new window.FileReader()
        reader.readAsDataURL(file)
        reader.onload = e => {
//          console.log(e.target.result)
          var mime = e.target.result.split(';')
          var mimeType = (mime[0].split(':')[1])
          var data = mime[1].substring(7)
          // this.avatar = e.target.result;
          this.$emit('fileLoaded', {
            src: e.target.result,
            file: file,
            mime: mimeType,
            base64: data,
            fileName: this.fileName,
            category: this.category,
            key1: this.key1,
            key2: this.key2
          })
        }
        // this.persist(file);
      }
    },
    watch: {
      doCheckFileError () {
        this.$validator.validateAll().then((result) => {
          if (!result) {
            this.$emit('errorInFileUpload', {
              key1: this.key1,
              key2: this.key2,
              isError: 1
            })
          }
        })
      }
    }
  }
</script>
