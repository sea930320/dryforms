<template>
	<b-row>
    <b-col class="text-left">
      <img :src="companyLogo" alt="Company Logo">
    </b-col>
    <b-col class="text-right">
      <h5 class="m-0">{{ title }}</h5>
      <p class="m-0">{{ street }}</p>
      <p class="m-0">{{ city }} {{ state }} {{ zipcode }}</p>
      <p class="m-0">{{ phone }}</p>
      <p class="m-0">{{ email }}</p>
    </b-col>
  </b-row>
</template>

<script type="text/babel">
  export default {
    name: 'form-header',
    data () {
      return {
        companyLogo: require('../../assets/fallback-logo.jpg'),
        title: 'Flood out',
        street: '8631 Rocky Ave',
        city: 'Las Vegas',
        state: 'Nevada',
        zipcode: '89143',
        phone: '702-591-8889',
        email: 'readyfloodrestoration@gmail.com'
      }
    }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
</style>