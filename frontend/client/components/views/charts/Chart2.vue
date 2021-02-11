<template>
  <div>
    <!--https://admin.vuebulma.com/#/charts/chartjs-->
    <div class="tile is-ancestor">
      <div class="tile is-parent is-4">
        <article class="tile is-child box" style="border-top:0px;">
          <chart :type="'bar'" :data="seriesData"  :options="options_3"></chart>
        </article>
      </div>
    </div>
    <!--<pre>{{ seriesData }}</pre>-->
  </div>
</template>

<script>
import Chart from 'vue-bulma-chartjs'

export default {
  components: {
    Chart
  },
  props: ['seriesData'],
  data () {
    return {

      labels_3: ['May', 'June', 'Jule', 'August', 'September', 'October', 'November'],
      data_3: [
        [6, 6, 6, 6, 6, 6, 6],
        [6, 6, 6, 6, 6, 6, 6]
      ],
      options_3: {
        tooltips: {
          mode: 'label'
        }
      },
      backgroundColor_3: [
        'rgba(31, 200, 219, 1)',
        'rgba(151, 205, 118, 1)'
      ],
      series: ['Client Quoting', 'My estimate'],
      ajaxFinish: false
//      seriesData: {}
    }
  },

  mounted () {
//    this.getChartData()
  },

  computed: {
//    seriesData: {
//      get: function () {
//        let data = {
//          labels: this.labels_3
//        }
//        data.datasets = this.series.map((e, i) => {
//          return {
//            data: this.data_3[i],
//            label: this.series[i],
//            borderColor: this.backgroundColor_3[i].replace(/1\)$/, '.5)'),
//            pointBackgroundColor: this.backgroundColor_3[i],
//            backgroundColor: this.backgroundColor_3[i].replace(/1\)$/, '.5)')
//          }
//        })
//        return data
//      },
//      set: function (newValue) {
//      }
//    }
  },
  watch: {
//    seriesData (newValue) {
//      console.log('series data changed')
//      console.log(newValue)
//      this.seriesData = newValue
//    },
//    data_3 (newValue) {
//      console.log('series data changed')
//      console.log(newValue)
//      this.data_3 = newValue
//    }
  }
//  methods: {
//    getChartData () {
//      this.$http({
//        url: process.env.API_URL + '/api/dashboard/chart-data',
//        method: 'GET'
//      }).then((res) => {
//        console.log(res.data.labels)
//        console.log(res.data.data)
//        this.labels_3 = res.data.labels
//        this.data_3 = res.data.data
//
//        let data = {
//          labels: this.labels_3
//        }
//        data.datasets = this.series.map((e, i) => {
//          return {
//            data: this.data_3[i],
//            label: this.series[i],
//            borderColor: this.backgroundColor_3[i].replace(/1\)$/, '.5)'),
//            pointBackgroundColor: this.backgroundColor_3[i],
//            backgroundColor: this.backgroundColor_3[i].replace(/1\)$/, '.5)')
//          }
//        })
//        this.seriesData = data
//        this.ajaxFinish = true
//      })
//    }
//  }
}
</script>

<style scoped>
</style>
