<template>
  <infinite-loading spinner="bubbles"></infinite-loading>  
</template>

<script type="text/babel">
  import InfiniteLoading from 'vue-infinite-loading'

  export default {
    components: { InfiniteLoading }
  }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
  .infinite-loading-container {
    margin-top: 40vh;
  }
</style>