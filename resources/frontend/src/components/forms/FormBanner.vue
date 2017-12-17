<template>
  <b-row>
    <b-col cols="6" class="text-left">
      <p>Owner/Insured: {{ ownerName }}</p>
      <p>Job Address: {{ jobAddress }}</p>
    </b-col>
    <b-col cols="6" class="text-right">
      <p>Claim# {{ claimNumber }}</p>
    </b-col>
  </b-row>
</template>

<script type="text/babel">
  export default {
    data () {
      return {
        ownerName: 'Jimmy Smith',
        jobAddress: '905 Pastel Dusk Court Henderson, Nevada 89012',
        claimNumber: '1234567'
      }
    }
  }
</script>