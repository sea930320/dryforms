<template>
	<b-row>
		<b-col v-html="footerText" class="text-center"></b-col>
	</b-row>
</template>

<script type="text/babel">
  export default {
    data () {
      return {
        footerText: '<h2>Footer Text</h2>'
      }
    }
  }
</script>