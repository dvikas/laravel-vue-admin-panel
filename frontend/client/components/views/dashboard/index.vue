<template>
  <div>
    <!--http://ionicons.com/-->
    <!--http://ionicons.com/cheatsheet.html-->
    <section class="content-header">
      <h1>Dashboard</h1>
      <ol class="breadcrumb">
        <!--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!--<pre>{{ $auth.user() }}</pre>-->

    <section class="content">
      <!-- Info boxes -->
      <!--<div class="row">-->
        <!--<div class="col-md-3 col-sm-6 col-xs-12">-->
          <!--<div class="info-box">-->
            <!--<span class="info-box-icon bg-aqua"><i class="fa fa-gear"></i></span>-->

            <!--<div class="info-box-content">-->
              <!--<span class="info-box-text">Stats</span>-->
              <!--<span class="info-box-number">90<small>%</small></span>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
          <!--</div>-->
          <!--&lt;!&ndash; /.info-box &ndash;&gt;-->
        <!--</div>-->
        <!--&lt;!&ndash; /.col &ndash;&gt;-->
        <!--<div class="col-md-3 col-sm-6 col-xs-12">-->
          <!--<div class="info-box">-->
            <!--<span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>-->

            <!--<div class="info-box-content">-->
              <!--<span class="info-box-text">Likes</span>-->
              <!--<span class="info-box-number">41,410</span>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
          <!--</div>-->
          <!--&lt;!&ndash; /.info-box &ndash;&gt;-->
        <!--</div>-->
        <!--&lt;!&ndash; /.col &ndash;&gt;-->

        <!--&lt;!&ndash; fix for small devices only &ndash;&gt;-->
        <!--<div class="clearfix visible-sm-block"></div>-->

        <!--<div class="col-md-3 col-sm-6 col-xs-12">-->
          <!--<div class="info-box">-->
            <!--<span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>-->

            <!--<div class="info-box-content">-->
              <!--<span class="info-box-text">Sales</span>-->
              <!--<span class="info-box-number">760</span>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
          <!--</div>-->
          <!--&lt;!&ndash; /.info-box &ndash;&gt;-->
        <!--</div>-->
        <!--&lt;!&ndash; /.col &ndash;&gt;-->
        <!--<div class="col-md-3 col-sm-6 col-xs-12">-->
          <!--<div class="info-box">-->
            <!--<span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>-->

            <!--<div class="info-box-content">-->
              <!--<span class="info-box-text">New Clients</span>-->
              <!--<span class="info-box-number">2,000</span>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
          <!--</div>-->
          <!--&lt;!&ndash; /.info-box &ndash;&gt;-->
        <!--</div>-->
        <!--&lt;!&ndash; /.col &ndash;&gt;-->
      <!--</div>-->
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Recap Report</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8 col-sm-offset-2">
                  <!--<p class="text-center">-->
                    <!--<strong>Sales: 1 May, 2017 - 30 Nov, 2017</strong>-->
                  <!--</p>-->

                  <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <!--<canvas id="salesChart" style="height: 180px; width: 671px;" width="671" height="180"></canvas>-->
                    <bar-chart :seriesData="seriesData" v-if="ajaxFinish"></bar-chart>
                    <!--<line-chart></line-chart>-->
                  </div>
                  <!-- /.chart-responsive -->
                </div>
                <!-- /.col -->
                <!--<div class="col-md-4">-->
                  <!--<p class="text-center">-->
                    <!--<strong>Goal Completion</strong>-->
                  <!--</p>-->

                  <!--<div class="progress-group">-->
                    <!--<span class="progress-text">This is goal 1</span>-->
                    <!--<span class="progress-number"><b>160</b>/200</span>-->

                    <!--<div class="progress sm">-->
                      <!--<div class="progress-bar progress-bar-success" style="width: 12%"></div>-->
                    <!--</div>-->
                  <!--</div>-->
                  <!--&lt;!&ndash; /.progress-group &ndash;&gt;-->
                  <!--<div class="progress-group">-->
                    <!--<span class="progress-text">This is goal 2</span>-->
                    <!--<span class="progress-number"><b>310</b>/400</span>-->

                    <!--<div class="progress sm">-->
                      <!--<div class="progress-bar progress-bar-danger" style="width: 50%"></div>-->
                    <!--</div>-->
                  <!--</div>-->
                  <!--&lt;!&ndash; /.progress-group &ndash;&gt;-->
                  <!--<div class="progress-group">-->
                    <!--<span class="progress-text">This is goal 3</span>-->
                    <!--<span class="progress-number"><b>480</b>/800</span>-->

                    <!--<div class="progress sm">-->
                      <!--<div class="progress-bar progress-bar-info" style="width: 90%"></div>-->
                    <!--</div>-->
                  <!--</div>-->
                  <!--&lt;!&ndash; /.progress-group &ndash;&gt;-->
                  <!--<div class="progress-group">-->
                    <!--<span class="progress-text">Send Inquiries</span>-->
                    <!--<span class="progress-number"><b>250</b>/500</span>-->

                    <!--<div class="progress sm">-->
                      <!--<div class="progress-bar progress-bar-yellow" style="width: 70%"></div>-->
                    <!--</div>-->
                  <!--</div>-->
                  <!--&lt;!&ndash; /.progress-group &ndash;&gt;-->
                <!--</div>-->
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
            <div class="box-footer hide">
              <div class="row">
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>-->
                    <h5 class="description-header">$35,210.43</h5>
                    <span class="description-text">TOTAL REVENUE</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-xs-6">
                  <div class="description-block border-right">
                    <!--<span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>-->
                    <h5 class="description-header">$10,390.90</h5>
                    <span class="description-text">TOTAL COST</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <!--<div class="col-sm-3 col-xs-6">-->
                  <!--<div class="description-block border-right">-->
                    <!--<span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>-->
                    <!--<h5 class="description-header">$24,813.53</h5>-->
                    <!--<span class="description-text">TOTAL PROFIT</span>-->
                  <!--</div>-->
                  <!--&lt;!&ndash; /.description-block &ndash;&gt;-->
                <!--</div>-->
                <!--&lt;!&ndash; /.col &ndash;&gt;-->
                <!--<div class="col-sm-3 col-xs-6">-->
                  <!--<div class="description-block">-->
                    <!--<span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>-->
                    <!--<h5 class="description-header">1200</h5>-->
                    <!--<span class="description-text">GOAL COMPLETIONS</span>-->
                  <!--</div>-->
                  <!--&lt;!&ndash; /.description-block &ndash;&gt;-->
                <!--</div>-->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-12 ">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Project Calendar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" v-if="ajaxFinishCalendar" >
              <calendar :fcEvents="fcEvents"></calendar>
              <!--<pre>{{ fcEvents }}</pre>-->
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- MAP & BOX PANE -->
          <!--<div class="box box-success">-->
            <!--<div class="box-header with-border">-->
              <!--<h3 class="box-title">Project locations</h3>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.box-header &ndash;&gt;-->
            <!--<div class="box-body no-padding">-->
              <!--<div class="row">-->
                <!--<div class="col-md-9 col-sm-8">-->
                  <!--<div class="pad">-->
                    <!--<img src="~assets/img/australia.jpg">-->
                  <!--</div>-->
                <!--</div>-->
                <!--&lt;!&ndash; /.col &ndash;&gt;-->
                <!--<div class="col-md-3 col-sm-4">-->
                  <!--<div class="pad box-pane-right bg-green" style="min-height: 280px">-->
                    <!--<div class="description-block margin-bottom">-->
                      <!--<div class="sparkbar pad" data-color="#fff"><canvas style="display: inline-block; width: 34px; height: 30px; vertical-align: top;" width="34" height="30"></canvas></div>-->
                      <!--<h5 class="description-header">83</h5>-->
                      <!--<span class="description-text">Govt Tender</span>-->
                    <!--</div>-->
                    <!--&lt;!&ndash; /.description-block &ndash;&gt;-->
                    <!--<div class="description-block margin-bottom">-->
                      <!--<div class="sparkbar pad" data-color="#fff"><canvas style="display: inline-block; width: 34px; height: 30px; vertical-align: top;" width="34" height="30"></canvas></div>-->
                      <!--<h5 class="description-header">500</h5>-->
                      <!--<span class="description-text">Referrals</span>-->
                    <!--</div>-->
                    <!--&lt;!&ndash; /.description-block &ndash;&gt;-->
                    <!--<div class="description-block">-->
                      <!--<div class="sparkbar pad" data-color="#fff"><canvas style="display: inline-block; width: 34px; height: 30px; vertical-align: top;" width="34" height="30"></canvas></div>-->
                      <!--<h5 class="description-header">5462</h5>-->
                      <!--<span class="description-text">Self</span>-->
                    <!--</div>-->
                    <!--&lt;!&ndash; /.description-block &ndash;&gt;-->
                  <!--</div>-->
                <!--</div>-->
                <!--&lt;!&ndash; /.col &ndash;&gt;-->
              <!--</div>-->
              <!--&lt;!&ndash; /.row &ndash;&gt;-->
            <!--</div>-->
            <!--&lt;!&ndash; /.box-body &ndash;&gt;-->
          <!--</div>-->
          <!-- /.box -->

          <!-- TABLE: LATEST PROJECTS -->
          <!--<div class="box box-info">-->
            <!--<div class="box-header with-border">-->
              <!--<h3 class="box-title">Latest Projects</h3>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.box-header &ndash;&gt;-->
            <!--<div class="box-body">-->
              <!--<div class="table-responsive">-->
                <!--<table class="table no-margin">-->
                  <!--<thead>-->
                  <!--<tr>-->
                    <!--<th>Invoice ID</th>-->
                    <!--<th>Date</th>-->
                    <!--<th>Description</th>-->
                    <!--<th>Status</th>-->
                  <!--</tr>-->
                  <!--</thead>-->
                  <!--<tbody>-->
                  <!--<tr>-->
                    <!--<td><a href="#">OR9842</a></td>-->
                    <!--<td>12-Jan-2018</td>-->
                    <!--<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry</td>-->
                    <!--<td><span class="label label-success">Completed</span></td>-->

                  <!--</tr>-->
                  <!--<tr>-->
                    <!--<td><a href="#">OR1848</a></td>-->
                    <!--<td>03-Dec-2017</td>-->
                    <!--<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry</td>-->
                    <!--<td><span class="label label-warning">Pending</span></td>-->

                  <!--</tr>-->
                  <!--<tr>-->
                    <!--<td><a href="#">OR7429</a></td>-->
                    <!--<td>01-Dec-2017</td>-->
                    <!--<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry</td>-->
                    <!--<td><span class="label label-danger">Failed</span></td>-->

                  <!--</tr>-->
                  <!--<tr>-->
                    <!--<td><a href="#">OR7429</a></td>-->
                    <!--<td>01-Dec-2017</td>-->
                    <!--<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry</td>-->
                    <!--<td><span class="label label-info">Processing</span></td>-->

                  <!--</tr>-->
                  <!--<tr>-->
                    <!--<td><a href="#">OR1848</a></td>-->
                    <!--<td>01-Dec-2017</td>-->
                    <!--<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry</td>-->
                    <!--<td><span class="label label-warning">Pending</span></td>-->

                  <!--</tr>-->
                  <!--<tr>-->
                    <!--<td><a href="#">OR7429</a></td>-->
                    <!--<td>22-Nov-2017</td>-->
                    <!--<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry</td>-->
                    <!--<td><span class="label label-danger">Failed</span></td>-->

                  <!--</tr>-->
                  <!--<tr>-->
                    <!--<td><a href="#">OR9842</a></td>-->
                    <!--<td>22-Nov-2017</td>-->
                    <!--<td>Lorem Ipsum is simply dummy text of the printing and typesetting industry</td>-->
                    <!--<td><span class="label label-success">Completed</span></td>-->

                  <!--</tr>-->
                  <!--</tbody>-->
                <!--</table>-->
              <!--</div>-->
              <!--&lt;!&ndash; /.table-responsive &ndash;&gt;-->
            <!--</div>-->
            <!--&lt;!&ndash; /.box-body &ndash;&gt;-->
            <!--<div class="box-footer clearfix">-->
              <!--<a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Projects</a>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.box-footer &ndash;&gt;-->
          <!--</div>-->
          <!-- /.box -->

        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- Info Boxes Style 2 -->
          <!--<div class="info-box bg-yellow">-->
            <!--<span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>-->

            <!--<div class="info-box-content">-->
              <!--<span class="info-box-text">Inventory</span>-->
              <!--<span class="info-box-number">5,200</span>-->

              <!--<div class="progress">-->
                <!--<div class="progress-bar" style="width: 50%"></div>-->
              <!--</div>-->
              <!--<span class="progress-description">-->
                    <!--50% Increase in 30 Days-->
                  <!--</span>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
          <!--</div>-->
          <!-- /.info-box -->
          <!--<div class="info-box bg-green">-->
            <!--<span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>-->

            <!--<div class="info-box-content">-->
              <!--<span class="info-box-text">Mentions</span>-->
              <!--<span class="info-box-number">92,050</span>-->

              <!--<div class="progress">-->
                <!--<div class="progress-bar" style="width: 20%"></div>-->
              <!--</div>-->
              <!--<span class="progress-description">-->
                    <!--20% Increase in 30 Days-->
                  <!--</span>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
          <!--</div>-->
          <!-- /.info-box -->
          <!--<div class="info-box bg-red">-->
            <!--<span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>-->

            <!--<div class="info-box-content">-->
              <!--<span class="info-box-text">Downloads</span>-->
              <!--<span class="info-box-number">114,381</span>-->

              <!--<div class="progress">-->
                <!--<div class="progress-bar" style="width: 70%"></div>-->
              <!--</div>-->
              <!--<span class="progress-description">-->
                    <!--70% Increase in 30 Days-->
                  <!--</span>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
          <!--</div>-->
          <!-- /.info-box -->
          <!--<div class="info-box bg-aqua">-->
            <!--<span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>-->

            <!--<div class="info-box-content">-->
              <!--<span class="info-box-text">Direct Messages</span>-->
              <!--<span class="info-box-number">163,921</span>-->

              <!--<div class="progress">-->
                <!--<div class="progress-bar" style="width: 40%"></div>-->
              <!--</div>-->
              <!--<span class="progress-description">-->
                    <!--40% Increase in 30 Days-->
                  <!--</span>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.info-box-content &ndash;&gt;-->
          <!--</div>-->
          <!-- /.info-box -->
          <!-- /.box -->

          <!-- USERS LIST -->
          <!--<div class="box box-danger">-->
            <!--<div class="box-header with-border">-->
              <!--<h3 class="box-title">Latest Clients</h3>-->

              <!--<div class="box-tools pull-right">-->
                <!--<span class="label label-danger">8 New Clients</span>-->
              <!--</div>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.box-header &ndash;&gt;-->
            <!--<div class="box-body no-padding">-->
              <!--<ul class="users-list clearfix">-->
                <!--<li>-->
                  <!--<img src="~assets/img/user1-128x128.jpg" alt="User Image">-->
                  <!--<a class="users-list-name" href="#">Alexander Pierce</a>-->
                  <!--<span class="users-list-date">Today</span>-->
                <!--</li>-->
                <!--<li>-->
                  <!--<img src="~assets/img/user8-128x128.jpg" alt="User Image">-->
                  <!--<a class="users-list-name" href="#">Norman</a>-->
                  <!--<span class="users-list-date">Yesterday</span>-->
                <!--</li>-->
                <!--<li>-->
                  <!--<img src="~assets/img/user7-128x128.jpg" alt="User Image">-->
                  <!--<a class="users-list-name" href="#">Jane</a>-->
                  <!--<span class="users-list-date">12 Jan</span>-->
                <!--</li>-->
                <!--<li>-->
                  <!--<img src="~assets/img/user6-128x128.jpg" alt="User Image">-->
                  <!--<a class="users-list-name" href="#">John</a>-->
                  <!--<span class="users-list-date">12 Jan</span>-->
                <!--</li>-->
                <!--<li>-->
                  <!--<img src="~assets/img/user2-160x160.jpg" alt="User Image">-->
                  <!--<a class="users-list-name" href="#">Alexander</a>-->
                  <!--<span class="users-list-date">13 Jan</span>-->
                <!--</li>-->
                <!--<li>-->
                  <!--<img src="~assets/img/user5-128x128.jpg" alt="User Image">-->
                  <!--<a class="users-list-name" href="#">Sarah</a>-->
                  <!--<span class="users-list-date">14 Jan</span>-->
                <!--</li>-->
                <!--<li>-->
                  <!--<img src="~assets/img/user4-128x128.jpg" alt="User Image">-->
                  <!--<a class="users-list-name" href="#">Nora</a>-->
                  <!--<span class="users-list-date">15 Jan</span>-->
                <!--</li>-->
                <!--<li>-->
                  <!--<img src="~assets/img/user3-128x128.jpg" alt="User Image">-->
                  <!--<a class="users-list-name" href="#">Nadia</a>-->
                  <!--<span class="users-list-date">15 Jan</span>-->
                <!--</li>-->
              <!--</ul>-->
              <!--&lt;!&ndash; /.users-list &ndash;&gt;-->
            <!--</div>-->
            <!--&lt;!&ndash; /.box-body &ndash;&gt;-->
            <!--<div class="box-footer text-center">-->
              <!--<a href="javascript:void(0)" class="uppercase">View All Clients</a>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.box-footer &ndash;&gt;-->
          <!--</div>-->
          <!--/.box -->

          <!-- /.row -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>
</template>

<script>
import Calendar from '../../views/Calendar'
import BarChart from '../../views/charts/Chart2'
import LineChart from '../../views/charts/Chartjs'

export default {
  components: {
    Calendar,
    BarChart,
    LineChart
  },

  data () {
    return {
      data: [300, 50, 100],
      seriesData: {},
      fcEvents: [],
      ajaxFinish: false,
      ajaxFinishCalendar: false,
      series: ['Client Quoting', 'My estimate'],
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
      ]
    }
  },
  created () {
    this.getChartData()
    this.getCalendarData()
  },
  methods: {
    getCalendarData () {
      this.$http({
        url: process.env.API_URL + '/api/dashboard/calendar',
        method: 'GET'
      }).then((res) => {
        console.log(res.data)
        this.fcEvents = res.data
        this.ajaxFinishCalendar = true
      })
    },

    getChartData () {
      this.$http({
        url: process.env.API_URL + '/api/dashboard/chart-data',
        method: 'GET'
      }).then((res) => {
//        if (res.status === 200) {
//        console.log(res.data.labels)
//        console.log(res.data.data)
        this.labels_3 = res.data.labels
        this.data_3 = res.data.data
//        }

        let data = {
          labels: this.labels_3
        }
        data.datasets = this.series.map((e, i) => {
          return {
            data: this.data_3[i],
            label: this.series[i],
            borderColor: this.backgroundColor_3[i].replace(/1\)$/, '.5)'),
            pointBackgroundColor: this.backgroundColor_3[i],
            backgroundColor: this.backgroundColor_3[i].replace(/1\)$/, '.5)')
          }
        })
        this.seriesData = data
        this.ajaxFinish = true
        return true
      })
    }
  },
  computed: {
    chartData () {
      return {
        labels: [
          'Red',
          'Blue',
          'Yellow'
        ],
        datasets: [{
          data: this.data,
          backgroundColor: [
            '#FF6384',
            '#36A2EB',
            '#FFCE56'
          ]
        }]
      }
    }
  }

//  mounted () {
//    setInterval(() => {
//      // https://github.com/vuejs/vue/issues/2873
//      // Array.prototype.$set/$remove deprecated (use Vue.set or Array.prototype.splice instead)
//      this.data.forEach((item, i) => {
//        this.data.splice(i, 1, Math.ceil(Math.random() * 1000))
//      })
//    }, 1024)
//  }
}
</script>

<style lang="scss" scoped>
</style>
