<template>
  <div class="card">
    <div class="card-body text-center">
      <form-header></form-header> 
      <h4 class="mb-2">{{ $route.meta.title }}</h4>
      <div class="dropdown-divider"></div>
      <form-banner class="mt-2"></form-banner>
      <div class="dropdown-divider"></div>
      <div v-html="certContent"></div>
      <notes class="mt-3"></notes>
      <footer-text class="mt-3"></footer-text>
      <signature class="mt-3"></signature>
    </div>
  </div>
</template>

<script type="text/babel">
  import FormHeader from './FormHeader'
  import FormBanner from './FormBanner'
  import Notes from './Notes'
  import FooterText from './FooterText'
  import Signature from './Signature'

  export default {
    components: { FormHeader, FormBanner, Notes, FooterText, Signature },
    data () {
      return {
        certContent: '<h2>Certificate of Completion Data</h2>'
      }
    }
  }
</script>