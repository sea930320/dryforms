<template>
  <b-modal id="selectForm" :title="$route.meta.title" v-model="showModal">
    <b-form-checkbox-group stacked v-model="selelctedForm" :options="forms">      
    </b-form-checkbox-group>    
    <div slot="modal-footer" class="w-100">
      <b-btn variant="primary" class="float-right" @click="saveForm()">Save</b-btn>
    </div>
  </b-modal>
</template>

<script type="text/babel">
  export default {
    data () {
      return {
        showModal: true,
        selelctedForm: [],
        forms: [
          { text: 'Call Report', value: 1 },
          { text: 'Job Scope', value: 2 },
          { text: 'Daily Log', value: 3 },
          { text: 'Work Authorization', value: 4 },
          { text: 'Customer Responsibility', value: 5 },
          { text: 'Anti-Microbial', value: 6 },
          { text: 'Moisture Map', value: 7 },
          { text: 'Psychometric Report', value: 8 },
          { text: 'Release from Liability', value: 9 },
          { text: 'Work Stoppage', value: 10 },
          { text: 'Certificate of Completion', value: 11 }
        ]
      }
    },
    watch: {
      showModal: function () {
        if (!this.showModal) this.$router.push('/projects')
      }
    },
    methods: {
      saveForm () {
        console.log(this.selelctedForm)
        this.$router.push('/forms/callreport')
      }
    }
  }
</script>