<template>
<div class="col-sm-offset-2 col-sm-8">
  <!--https://github.com/Wanderxx/vue-fullcalendar-->
  <!--https://www.tallent.us/vue-simple-calendar/-->
  <!--https://github.com/richardtallent/vue-simple-calendar-->

  <!--https://github.com/CroudSupport/vue-fullcalendar-->
  <!--https://github.com/BrockReece/vue-fullcalendar-example-->
  <!--https://github.com/EazyServer/Vue-Bootstrap-Calendar-->

    <!--<a v-if="$auth.check({ role_code: [ roles.ADMIN, roles.PUBLIC ] })">admin</a>-->
    <!--<a v-if="$auth.check('admin')">admin</a>-->

  <full-calendar :events="fcEvents"
                 first-day="1"
                 @changeMonth="changeMonth"
                 @eventClick="eventClick"
                 @dayClick="dayClick"
                 @moreClick="moreClick"
                 locale="en">
    <template slot="fc-event-card" slot-scope="p">
      <p><i class="fa">sadfsd</i> {{ p.event.title }} test</p>
    </template>

  </full-calendar>

    <!--{{ $auth.rolesVar }}-->
    <!--{{ $auth.user() }}-->

</div>
</template>

<script>
  import fullCalendar from 'vue-fullcalendar'
//  import /vue-fullcalendar/src/components/header.vue
  export default {
    name: 'myForm',
    components: {
      fullCalendar
    },
    props: ['fcEvents'],
    data () {
      return {

//        fcEvents: [
//          {
//            title: 'event1',
//            start: '2018-02-01',
//            cssClass: ['career']
//          },
//          {
//            title: 'Work in Progress ',
//            start: '2018-02-11',
//            end: '2018-02-18',
//            cssClass: ['family']
//          },
//          {
//            title: 'Work in Progress ',
//            start: '2018-02-11',
//            end: '2018-02-18',
//            cssClass: ['career']
//          }, {
//            title: 'Work in Progress ',
//            start: '2018-02-11',
//            end: '2018-02-18',
//            cssClass: ['career']
//          }, {
//            title: 'Work in Progress ',
//            start: '2018-02-11',
//            end: '2018-02-18',
//            cssClass: ['family']
//          }, {
//            title: 'Work in Progress ',
//            start: '2018-02-11',
//            end: '2018-02-18',
//            cssClass: ['family']
//          }
//        ]
      }
    },
    mixins: [],

    methods: {
      'changeMonth' (start, end, current) {
        console.log('changeMonth', start, end, current)
      },
      'eventClick' (event, jsEvent, pos) {
        console.log('eventClick', event, jsEvent, pos)
      },
      'dayClick' (day, jsEvent) {
        console.log('dayClick', day, jsEvent)
      },
      'moreClick' (day, events, jsEvent) {
        console.log('moreCLick', day, events, jsEvent)
      }
    }
  }

</script>

<style lang="scss" scoped>
  .event-box {
    p.event-item.career {
      background-color: #00C0EF;
    }
    p.event-item.family {
      background-color: #00A65A;
    }
  }

</style>
