<template>
	<b-row>
    <b-col>
      <img src="" alt="Company Logo">
    </b-col>
    <b-col></b-col>
    <b-col class="text-right">
      <h5 style="margin:0;">{{ title }}</h5>
      <p style="margin:0;">{{ street }}</p>
      <p style="margin:0;">{{ city }} {{ state }} {{ zipcode }}</p>
      <p style="margin:0;">{{ phone }}</p>
      <p style="margin:0;">{{ email }}</p>
    </b-col>
  </b-row>
</template>

<script type="text/babel">
  export default {
    data () {
      return {
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

<style type="text/css" scoped>
</style>