<template>
  <div class="card" style="min-height: 100vh;">
    <div class="card-body text-center">
      <form-header></form-header> 
      <h4 class="mb-2">{{ $route.meta.title }}</h4>
      <div class="dropdown-divider"></div>
      <form-banner class="mt-2"></form-banner>
      <div class="dropdown-divider"></div>
      <b-row v-for="item in logData" :key="item.logTime">
        <b-col class="text-left">
          <p>
            <span style="font-weight:bold;">{{ item.logTime }} {{ item.logUser }}</span>
            <span>&nbsp;-&nbsp;{{ item.logContent }}</span>
          </p>
        </b-col>        
      </b-row>
    </div>
  </div>
</template>

<script type="text/babel">
  import FormHeader from './FormHeader'
  import FormBanner from './FormBanner'

  export default {
    components: { FormHeader, FormBanner },
    data () {
      return {
        logData: [
          {
            logTime: '12/12/17 00:00:00',
            logUser: 'Randy Evans',
            logContent: 'Placed 3 air movers in the Master Bedroom.'
          },
          {
            logTime: '12/12/17 00:00:00',
            logUser: 'Randy Evans',
            logContent: 'Found 2 air movers and 1 dehumidifier turned off upon arrival to take daily readings. Restored power back on 2 air movers and 1 dehumidifier. Owner said they could not hear the television. '
          },
          {
            logTime: '12/12/17 00:00:00',
            logUser: 'Randy Evans',
            logContent: 'Enformed owner that not having the equipment turned on could possibly result in extended dry times and mold growth.'
          }
        ]
      }
    }
  }
</script>