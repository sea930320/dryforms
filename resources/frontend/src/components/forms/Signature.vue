<template>
    <b-container v-if='isLoaded'>
        <b-row class="mb-2">
            <b-col cols="3" class="text-left pt-4">
                <h6>Owner/Insured:</h6>
                <p>{{ ownerName }}</p>
            </b-col>
            <b-col cols="6">
                <b-row align-h="center">
                    <b-col cols="2" class="text-right">
                        <i class="fa fa-times" @click="clearOwner"></i>
                    </b-col>
                    <b-col cols="8" style="height:80px; border-bottom: 1px solid;" @click="showOwnerModal">
                        <b-row>
                            <img class="m-auto" v-if="ownerSignaturePng" :src="ownerSignaturePng"/>
                        </b-row>
                    </b-col>                    
                </b-row>
            </b-col>
            <b-col cols="3" class="text-right pt-4">
                <!-- <h6>Date: {{ ownerSignatureUpdatedAt.split(' ')[0] }}</h6>
                <p>{{ ownerSignatureUpdatedAt.split(' ')[1] }}</p> -->
                <date-picker v-model="ownerSignatureUpdatedAt" type="datetime" format="yyyy-MM-dd HH:mm:ss" lang="en" @input="changeOwnerDate(ownerSignatureUpdatedAt)" placeholder="Select Datetime"></date-picker>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols="3" class="text-left pt-4">
                <h6>Company:</h6>
                <p>{{ companyName }}</p>
            </b-col>
            <b-col cols="6">
                <b-row align-h="center">
                    <b-col cols="2" class="text-right">
                        <i class="fa fa-times" @click="clearCompany"></i>
                    </b-col>             
                    <b-col cols="8" style="height:80px; border-bottom: 1px solid;" @click="showCompanyModal">
                        <img class="m-auto" v-if="companySignaturePng" :src="companySignaturePng"/>
                    </b-col>                    
                </b-row>
            </b-col>
            <b-col cols="3" class="text-right pt-4">
                <!-- <h6>Date: {{ companySignatureUpdatedAt.split(' ')[0] }}</h6>
                <p>{{ companySignatureUpdatedAt.split(' ')[1] }}</p> -->
                <date-picker v-model="companySignatureUpdatedAt" type="datetime" format="yyyy-MM-dd HH:mm:ss" lang="en" @input="changeCompanyDate(companySignatureUpdatedAt)" placeholder="Select Datetime"></date-picker>
            </b-col>
        </b-row>
        <b-modal ref="ownerSignatureModalRef" size="md" title="Owner Signature" @ok="saveOwnerSignature">
            <vueSignature ref="ownerSignature" w="450px" h="150px" :sigOption="onwerSignOption" class="signature m-auto"></vueSignature>
        </b-modal>
        <b-modal ref="companySignatureModalRef" size="md" title="CompanySignature" @ok="saveCompanySignature">
            <vueSignature ref="companySignature" w="450px" h="150px" :sigOption="companySignOption" class="signature m-auto"></vueSignature>
        </b-modal>
    </b-container>
</template>

<script type="text/babel">
    import ErrorHandler from '../../mixins/error-handler'
    import apiProjectFormSignature from '../../api/project_signature'
    import DatePicker from 'vue2-datepicker'

    export default {
        mixins: [ErrorHandler],
        name: 'signature',
        components: {DatePicker},
        data() {
            return {
                test: null,
                date: '12/12/2017',
                time: '0:00:00',
                ownerSignaturePng: '',
                ownerSignatureUpdatedAt: null,
                companySignaturePng: '',
                companySignatureUpdatedAt: null,
                form_id: '',
                project_id: '',
                onwerSignOption: {
                    penColor: 'rgb(255, 0, 0)'
                },
                companySignOption: {
                    penColor: 'rgb(255, 0, 0)'
                }
            }
        },
        created() {
            this.project_id = this.$route.params.project_id
            this.form_id = this.$route.params.form_id
        },
        methods: {
            showOwnerModal() {
                this.$refs.ownerSignatureModalRef.show()
                let canvasEle = document.getElementsByTagName('canvas')
                canvasEle[0].setAttribute('width', '450')
                canvasEle[0].setAttribute('height', '150')
            },
            showCompanyModal() {
                this.$refs.companySignatureModalRef.show()
                let canvasEle = document.getElementsByTagName('canvas')
                canvasEle[1].setAttribute('width', '450')
                canvasEle[1].setAttribute('height', '150')
            },
            saveOwnerSignature() {
                let moment = this.$moment()
                this.ownerSignatureUpdatedAt = moment.format('YYYY-MM-DD hh:mm:ss')
                this.ownerSignaturePng = this.$refs.ownerSignature.save()
                this.saveSignature()
            },
            saveCompanySignature() {
                let moment = this.$moment()
                this.companySignatureUpdatedAt = moment.format('YYYY-MM-DD hh:mm:ss')
                this.companySignaturePng = this.$refs.companySignature.save()
                this.saveSignature()
            },
            clearOwner() {
                var _this = this
                _this.$refs.ownerSignature.clear()
                this.ownerSignaturePng = ''
                this.ownerSignatureUpdatedAt = null
                this.saveSignature()
            },
            clearCompany() {
                var _this = this
                _this.$refs.companySignature.clear()
                this.companySignaturePng = ''
                this.companySignatureUpdatedAt = null
                this.saveSignature()
            },
            saveSignature() {
                apiProjectFormSignature.store({
                    project_id: this.project_id,
                    form_id: this.form_id,
                    insured_signature: this.ownerSignaturePng,
                    company_signature: this.companySignaturePng,
                    insured_signature_upated_at: this.ownerSignatureUpdatedAt,
                    company_signature_upated_at: this.companySignatureUpdatedAt
                })
                    .then(res => {
                    }).catch(this.handleErrorResponse)
            },
            changeOwnerDate(signatureUpdatedAt) {
                if (signatureUpdatedAt) {
                    let moment = this.$moment(signatureUpdatedAt)
                    this.ownerSignatureUpdatedAt = moment.format('YYYY-MM-DD hh:mm:ss')
                }
                this.saveSignature()
            },
            changeCompanyDate(signatureUpdatedAt) {
                if (signatureUpdatedAt) {
                    let moment = this.$moment(signatureUpdatedAt)
                    this.companySignatureUpdatedAt = moment.format('YYYY-MM-DD hh:mm:ss')
                }
                this.saveSignature()
            }
        },
        computed: {
            ownerName: function() {
                return this.$store.state.ProjectForm.callReport ? this.$store.state.ProjectForm.callReport.insured_name : ''
            },
            companyName: function() {
                return this.$store.state.User.company.length !== 0 ? this.$store.state.User.company.name : ''
            },
            projectFormPerID: function() {
                let projectForms = this.$store.getters.projectFormPerID(this.form_id)
                if (projectForms.length > 0) {
                    this.ownerSignaturePng = projectForms[0].insured_signature
                    this.companySignaturePng = projectForms[0].company_signature
                    this.ownerSignatureUpdatedAt = projectForms[0].insured_signature_upated_at
                    this.companySignatureUpdatedAt = projectForms[0].company_signature_upated_at
                }
                return projectForms.length > 0 ? projectForms[0] : null
            },
            isLoaded: function() {
                return this.$store.state.User.company.length !== 0 && this.$store.state.ProjectForm.callReport && this.projectFormPerID
            }
        },
        watch: {
            '$route' (to, from) {
                this.project_id = this.$route.params.project_id
                this.form_id = this.$route.params.form_id
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .signature {
        border-bottom: 1px solid black;
    }
</style>