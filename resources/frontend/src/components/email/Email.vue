<template>
    <b-modal id="selectForm" :title="$route.meta.title" v-model="showModal">
        <h6>Select Forms to Email</h6>
        <b-form-checkbox-group stacked v-model="selectedForm" :options="forms"></b-form-checkbox-group>
        <h6>Select PDF type</h6>
        <b-form-radio-group stacked v-model="selectedPDFType" :options="pdfTypes"></b-form-radio-group>
        <h6>Select recipients of the Email</h6>
        <b-form-checkbox-group stacked v-model="selectedRecipients" :options="recipients"></b-form-checkbox-group>
        <input type="text" v-model="address" name="">
        <div slot="modal-footer" class="w-100">
            <b-btn variant="primary" class="float-right" @click="saveForm()">Save</b-btn>
        </div>
    </b-modal>
</template>

<script type="text/babel">
    import apiProjectEmail from '../../api/email'
    export default {
        data() {
            return {
                showModal: true,
                selectedForm: [],
                selectedPDFType: null,
                selectedRecipients: [],
                address: null,
                projectId: null,
                forms: [
                    {text: 'Call Report', value: 1},
                    {text: 'Job Scope', value: 2},
                    {text: 'Daily Log', value: 3},
                    {text: 'Work Authorization', value: 4},
                    {text: 'Customer Responsibility', value: 5},
                    {text: 'Anti-Microbial', value: 6},
                    {text: 'Moisture Map', value: 7},
                    {text: 'Psychometric Report', value: 8},
                    {text: 'Release from Liability', value: 9},
                    {text: 'Work Stoppage', value: 10},
                    {text: 'Certificate of Completion', value: 11}
                ],
                pdfTypes: [
                    {text: 'Sent as individual PDF', value: 1},
                    {text: 'Sent as one PDF', value: 2}
                ],
                recipients: [
                    {text: 'Owner/Insured', value: 1},
                    {text: 'Self', value: 2},
                    {text: 'Manual', value: 3}
                ]
            }
        },
        created() {
            this.projectId = parseInt(this.$route.params.project_id)
        },
        watch: {
            showModal: function () {
                if (!this.showModal) this.$router.go(-1)
            }
        },
        methods: {
            saveForm() {
                if (this.selectedPDFType === 2) {
                    apiProjectEmail.index({
                        selectedForm: this.selectedForm,
                        selectedPDFType: this.selectedPDFType,
                        selectedRecipients: this.selectedRecipients,
                        project_id: this.projectId,
                        address: this.address
                    }).then((res) => {
                    })
                } else {
                    let lastform = null
                    this.selectedForm.forEach(oneform => {
                        lastform = oneform
                    })
                    this.selectedForm.forEach(oneform => {
                        apiProjectEmail.index({
                            selectedForm: oneform,
                            selectedPDFType: this.selectedPDFType,
                            selectedRecipients: this.selectedRecipients,
                            project_id: this.projectId,
                            lastForm: lastform,
                            allFroms: this.selectedForm,
                            address: this.address
                        }).then((res) => {
                            console.log(res.data)
                        })
                    })
                }
                this.$router.go(-1)
            }
        }
    }
</script>