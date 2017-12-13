<template>
	<b-modal id="selectForm" :title="$route.meta.title" v-model="show">
		<b-form-checkbox-group stacked v-model="selectForm" :options="forms">			
		</b-form-checkbox-group>		
		<div slot="modal-footer" class="w-100">
      <b-btn class="float-right" @click="saveForm()">Save</b-btn>
    </div>
	</b-modal>
</template>

<script type="text/babel">
  export default {
    data () {
      return {
        show: true,
        selelctedForm: [],
        forms: [
          { text: 'Call Report', value: 1 },
          { text: 'Job Scope', value: 2 }
        ]
      }
    },
    watch: {
      show: function () {
        if (this.show === false) this.$router.push('/projects')
      }
    },
    methods: {
      saveForm () {
        this.$router.push('/forms/callreport')
      }
    }
  }
</script>