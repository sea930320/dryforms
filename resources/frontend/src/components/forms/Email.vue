<template>
  <b-modal id="selectForm" :title="$route.meta.title" v-model="showModal">
    <h6>Select Forms to Email</h6>
    <b-form-checkbox-group stacked v-model="selelctedForm" :options="forms"></b-form-checkbox-group>
    <h6>Select PDF type</h6>
    <b-form-checkbox-group stacked v-model="selelctedPDFType" :options="pdfTypes"></b-form-checkbox-group>
    <h6>Select recipients of the Email</h6>
    <b-form-checkbox-group stacked v-model="selelctedRecipients" :options="recipients"></b-form-checkbox-group>
    <input type="text" name="">
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
        selelctedPDFType: [],
        selelctedRecipients: [],
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
        ],
        pdfTypes: [
          { text: 'Sent as individual PDF', value: 1 },
          { text: 'Sent as one PDF', value: 2 }
        ],
        recipients: [
          { text: 'Owner/Insured', value: 1 },
          { text: 'Sent as one PDF', value: 2 },
          { text: 'Self', value: 3 },
          { text: 'Manual', value: 4 }
        ]
      }
    },
    watch: {
      showModal: function () {
        if (!this.showModal) this.$router.go(-1)
      }
    },
    methods: {
      saveForm () {
        console.log(this.selelctedForm)
        this.$router.go(-1)
      }
    }
  }
</script>