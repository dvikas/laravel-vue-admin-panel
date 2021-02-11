<template>
  <div>
    <ul class="pagination pagination-large" v-if="shouldPaginate">
      <li :class=" page === 1 ? 'disabled':'' "><a href="#" @click.prevent="page--">&laquo;</a></li>

      <li v-for="pageNum in totalPages" :class="isActive(pageNum)"><a href="#" @click.prevent="page=pageNum">{{ pageNum
        }}</a></li>

      <li :class=" page === totalPages ? 'disabled':'' "><a href="#" @click.prevent="page++">&raquo;</a></li>

    </ul>
  </div>
</template>

<script>
  export default {
    props: ['dataSet'],
    name: 'paginator',
    data () {
      return {
        page: 1,
        currentPage: 1,
        totalPages: 1
      }
    },
    computed: {
      shouldPaginate () {
        return !!(this.totalPages > 1)
      }
    },
    created () {
      this.page = this.dataSet.current_page === undefined ? 1 : this.dataSet.current_page
      this.currentPage = this.dataSet.current_page === undefined ? 1 : this.dataSet.current_page
      this.totalPages = this.dataSet.total_pages === undefined ? 1 : this.dataSet.total_pages
    },
    methods: {
      broadcast () {
        this.$emit('updatePaginate', this.page)
        return this
      },
      isActive (pageNum) {
        return this.page === pageNum ? 'active' : ''
      },
      updateUrl () {
        history.pushState('', '', '?page=' + this.page)
      }
    },
    watch: {
      dataSet () {
        this.page = this.dataSet.current_page
        this.currentPage = this.dataSet.current_page
        this.totalPages = this.dataSet.total_pages
      },
      page () {
        this.broadcast().updateUrl()
      }
    }

  }
</script>

<style scoped>

</style>
