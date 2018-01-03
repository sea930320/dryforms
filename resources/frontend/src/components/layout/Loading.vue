<template>
  <div>
    <stretch></stretch>
  </div>
</template>

<script type="text/babel">
  import { Stretch } from 'vue-loading-spinner'

  export default {
    name: 'loading',
    components: { Stretch }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
  .spinner {
    margin-top: 40vh;
    margin-left: 50%;
  }
</style>