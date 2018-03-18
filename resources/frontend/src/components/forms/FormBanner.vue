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
    import apiProjectCallReports from '../../api/project_call_reports'

    export default {
        data() {
            return {
                projectId: null,
                formId: null,
                ownerName: '',
                jobAddress: '',
                claimNumber: ''
            }
        },
        created() {
            this.projectId = this.$route.params.project_id
            this.formId = this.$route.params.form_id
            this.init()
        },
        methods: {
            init() {
                apiProjectCallReports.index({
                    project_id: this.projectId
                }).then(res => {
                    if (res.data.length > 0) {
                        this.ownerName = res.data[0].insured_name
                        this.jobAddress = res.data[0].billing_address
                        this.claimNumber = res.data[0].insurance_claim_no
                    }
                })
            }
        }
    }
</script>