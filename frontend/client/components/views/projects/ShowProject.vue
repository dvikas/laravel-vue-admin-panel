<template>
  <div>
    <section class="content-header">
      <h1>Project Details<small>(INVOICE: <a href="#">#OR1848</a>)</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Project</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="~assets/img/user4-128x128.jpg" alt="User profile picture">

            <h3 class="profile-username text-center">
              Julia Roberts  <small>(Contractor)</small></h3>

            <p class="text-muted text-center">+91-9711500404<br><a href="#">hello@world.com</a></p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Billed amount</b> <a class="pull-right">$1,322</a>
              </li>
              <li class="list-group-item">
                <strong><i class="fa fa-map-marker margin-r-5"></i> Address</strong>
                <p class="text-muted">465, North view road, Sydney</p>
              </li>
              <li class="list-group-item">
                <strong><i class="fa fa-map-marker margin-r-5"></i>Site Address</strong>
                <p class="text-muted">465, North view road, Sydney</p>
              </li>
              <li class="list-group-item">
                <b>Project type</b> <a class="pull-right">Renovation</a>
              </li>
              <li class="list-group-item">
                <b>Type of use</b> <a class="pull-right">Children</a>
              </li>
            </ul>
            <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            <a href="#" class="btn btn-primary btn-block"><i class="fa fa fa-envelope-o"></i>&nbsp;Resend Invoice</a>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Activity</a></li>
            <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Project Timeline</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="activity">

              <h2 class="page-header inner-page-heading text-info" >
                Milestones <span style="font-size: 14px;">(committed stage)</span>
                <span class="pull-right text-success"><em>TOTAL:</em>&nbsp;$12,000</span>
              </h2>
              <div class="box box-solid box-auto-height">
                <div class="box-header with-border text-center">
                  <div class="row">
                    <div class="col-sm-4 ">
                      <div class="input-group">
                        <h4>Milestone 1</h4>
                      </div>

                    </div>
                  </div>

                </div>
                <div class="box-body">

                  <div class="row margin-bottom">
                    <div class="col-sm-3 ">
                      <checkbox v-model="milestonesSubtask.children" true-value="children"
                                type="info">SubTask 1</checkbox>
                    </div>

                    <div class="col-sm-2 ">
                      <div class="input-group">
                        <span class="input-group-addon">Qty</span>
                        <input type="text" readonly class="form-control"
                               placeholder="Quantity" value="2">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="input-group">
                        <span class="input-group-addon">Unit</span>
                        <input type="text" class="form-control" readonly
                               placeholder="Unit" value="23">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" class="form-control" readonly
                               value="100" placeholder="Rate">

                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="input-group">

                        <span class="input-group-addon">$</span>
                        <input type="text" class="form-control" readonly
                               value="400" placeholder="Total">
                        <span class="input-group-btn">
             <button title="Delete Subtask" class="btn btn-link" type="button">
               <i class="fa fa-trash text-maroon"></i></button>
            </span>

                      </div>
                    </div>

                  </div>
                  <div class="row margin-bottom">
                    <div class="col-sm-3 ">
                      <radio v-model="projectType" selected-value="reno"
                             type="info">Outsourced
                      </radio>
                    </div>

                    <div class="col-sm-2">
                      <div class="input-group">
                        <span class="input-group-addon">Qty</span>
                        <input type="text" class="form-control"
                               placeholder="Quantity" value="2">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="input-group">
                        <span class="input-group-addon">Unit</span>
                        <input type="text" class="form-control"
                               placeholder="Unit" value="23">
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" class="form-control"
                               value="100" placeholder="Rate">

                      </div>
                    </div>
                    <div class="col-sm-3">
                      <div class="input-group">

                        <span class="input-group-addon">$</span>
                        <input type="text" class="form-control"
                               value="400" placeholder="Total">


                      </div>
                    </div>

                  </div>

                  <div class="row">
                    <div class="col-sm-3 ">
                      <button type="submit" class="btn btn-link btn-info"><i class="fa
            fa-plus-circle"></i>&nbsp; Add new sub-category
                      </button>
                    </div>
                  </div>

                </div>
                <div class="box-footer price-table-footer">
                  <h4 class="pull-right">Sub Total:&nbsp;$6,000</h4>
                </div>
              </div>


              <div class="row">
                <div class="col-sm-12 ">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i>&nbsp;Add new milestone</button>
                </div>
              </div>

            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="timeline">
              <!-- The timeline -->
              <ul class="timeline timeline-inverse">
                <!-- timeline time label -->
                <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-envelope bg-blue"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                    <h3 class="timeline-header"><a href="#">Milestome completed email</a> sent to client</h3>

                    <div class="timeline-body">
                      Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                      weebly ning heekya handango imeem plugg dopplr jibjab, movity
                      jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                      quora plaxo ideeli hulu weebly balihoo...
                    </div>
                    <div class="timeline-footer">
                      <a class="btn btn-primary btn-xs">Read more</a>
                      <a class="btn btn-danger btn-xs">Delete</a>
                    </div>
                  </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-user bg-aqua"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                    <h3 class="timeline-header no-border"><a href="#">Milestone - Installed Gas Pipeline</a> completed
                    </h3>
                  </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-comments bg-yellow"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                    <h3 class="timeline-header"><a href="#">Jay White</a> added comment on milestone</h3>

                    <div class="timeline-body">
                      Take me to your leader!
                      Switzerland is small and neutral!
                      We are more like Germany, ambitious and misunderstood!
                    </div>
                    <div class="timeline-footer">
                      <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                    </div>
                  </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline time label -->
                <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-camera bg-purple"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                    <h3 class="timeline-header"><a href="#">Foo Bar</a> uploaded new certificates</h3>

                    <div class="timeline-body">
                      <img src="http://placehold.it/150x100" alt="..." class="margin">
                      <img src="http://placehold.it/150x100" alt="..." class="margin">
                      <img src="http://placehold.it/150x100" alt="..." class="margin">
                      <img src="http://placehold.it/150x100" alt="..." class="margin">
                    </div>
                  </div>
                </li>
                <!-- END timeline item -->
                <li>
                  <i class="fa fa-clock-o bg-gray"></i>
                </li>
              </ul>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
    </div>
    </section>
  </div>
</template>

<script>
  import { checkbox, radio } from 'vue-strap'

  export default {
    name: 'show-project',
    components: {
      checkbox,
      radio
    },
    data () {
      return {
        milestonesSubtask: ['children', 'family'],
        projectType: ['new', 'reno', 'ext']
      }
    },
    computed: {},
    methods: {}
  }
</script>

<style scoped>

</style>
