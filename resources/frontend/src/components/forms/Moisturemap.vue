<template>
  <div class="card">
    <div class="card-body text-center">
      <form-header></form-header>
      <h4 class="mb-2">{{ $route.meta.title }}</h4>
      <div class="dropdown-divider"></div>
      <form-banner></form-banner>
      <b-row>
        <b-col class="text-left">Instrument Make: Flir 501</b-col>
        <b-col>Instrument Model: 5654319</b-col>
        <b-col class="text-right">Setting: <8%</b-col>
      </b-row>
      <b-row>
        <b-col>
          <div class="bg-grey row-border p-1">
            <i class="fa fa-times text-danger"></i>
            Initial Inspection Date 12/12/17 00:00:00
          </div>          
        </b-col>
      </b-row>
      <mois-area title="Master Bedroom" class="mt-3"></mois-area>
      <mois-area title="Master Bath" class="mt-3"></mois-area>
      <mois-area title="Bedroom 1" class="mt-3"></mois-area>
      <mois-area title="Hallway" class="mt-3"></mois-area>
      <notes class="mt-3"></notes>
    </div>
  </div>
</template>

<script type="text/babel">
  import FormHeader from './FormHeader'
  import FormBanner from './FormBanner'
  import MoisArea from './MoisArea'
  import Notes from './Notes'

  export default {
    components: { FormHeader, FormBanner, MoisArea, Notes },
    data () {
      return {
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
  .row-border {
    border: 1px solid black;
  }
  .bg-grey {
    background-color: #c3c3c3;
  }
</style>

