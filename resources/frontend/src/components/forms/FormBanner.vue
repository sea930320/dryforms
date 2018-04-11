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
    import { mapActions } from 'vuex'

    export default {
        data() {
            return {
                projectId: null,
                formId: null
            }
        },
        created() {
            this.projectId = this.$route.params.project_id
            this.formId = this.$route.params.form_id
            this.init()
        },
        methods: {
            ...mapActions([
                'fetchCallReport'
            ]),
            init() {
                this.$store.state.ProjectForm.projectId = this.$route.params.project_id
                this.fetchCallReport()
            }
        },
        computed: {
          ownerName: function() {
              return this.$store.state.ProjectForm.callReport ? this.$store.state.ProjectForm.callReport.insured_name : ''
          },
          jobAddress: function() {
              return this.$store.state.ProjectForm.callReport ? this.$store.state.ProjectForm.callReport.job_address : ''
          },
          claimNumber: function() {
              return this.$store.state.ProjectForm.callReport ? this.$store.state.ProjectForm.callReport.insurance_claim_no : ''
          }
        }
    }
</script>