<template>
    <b-container v-if='isLoaded'>
        <b-row>
            <b-col cols="3" class="text-left pt-4">
                <h6>Owner/Insured:</h6>
                <p>{{ ownerName }}</p>
            </b-col>
            <b-col cols="6">
                <b-row>
                    <b-col cols="2" class="text-right">
                        <i class="fa fa-times" @click="clearOwner"></i>
                    </b-col>
                    <b-col cols="8">
                        <b-row>
                            <b-col cols="6">
                                <img v-if="ownerSignaturePng" :src="ownerSignaturePng"/>
                            </b-col>
                            <b-col cols="6">
                                <vueSignature ref="ownerSignature" :h="'80px'" :sigOption="onwerSignOption" class="signature"></vueSignature>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
            </b-col>
            <b-col cols="3" class="text-right pt-4">
                <h6>Date: {{ date }}</h6>
                <p>{{ time }}</p>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols="3" class="text-left pt-4">
                <h6>Company:</h6>
                <p>{{ companyName }}</p>
            </b-col>
            <b-col cols="6">
                <b-row>
                    <b-col cols="2" class="text-right">
                        <i class="fa fa-times" @click="clearCompany"></i>
                    </b-col>
                    <b-col cols="8">
                        <b-row>
                            <b-col cols="6">
                                <img v-if="companySignaturePng" :src="companySignaturePng"/>
                            </b-col>
                            <b-col cols="6">
                                <vueSignature ref="companySignature" :h="'80px'" :sigOption="companySignOption" class="signature"></vueSignature>
                            </b-col>
                        </b-row>                        
                    </b-col>
                </b-row>
            </b-col>
            <b-col cols="3" class="text-right pt-4">
                <h6>Date: {{ date }}</h6>
                <p>{{ time }}</p>
            </b-col>
        </b-row>
    </b-container>
</template>

<script type="text/babel">
    import ErrorHandler from '../../mixins/error-handler'
    import apiProjectFormSignature from '../../api/project_signature'

    export default {
        mixins: [ErrorHandler],
        name: 'signature',
        data() {
            return {
                date: '12/12/2017',
                time: '0:00:00',
                ownerSignaturePng: '',
                companySignaturePng: '',
                form_id: '',
                project_id: '',
                onwerSignOption: {
                    penColor: 'rgb(255, 0, 0)',
                    onEnd: this.saveOwnerSignature
                },
                companySignOption: {
                    penColor: 'rgb(255, 0, 0)',
                    onEnd: this.saveCompanySignature
                }
            }
        },
        created() {
            this.project_id = this.$route.params.project_id
            this.form_id = this.$route.params.form_id
        },
        methods: {
            saveOwnerSignature() {
                this.ownerSignaturePng = this.$refs.ownerSignature.save()
                this.saveSignature()
            },
            saveCompanySignature() {
                this.companySignaturePng = this.$refs.companySignature.save()
                this.saveSignature()
            },
            clearOwner() {
                var _this = this
                _this.$refs.ownerSignature.clear()
                this.ownerSignaturePng = ''
                this.saveSignature()
            },
            clearCompany() {
                var _this = this
                _this.$refs.companySignature.clear()
                this.companySignaturePng = ''
                this.saveSignature()
            },
            saveSignature() {
                apiProjectFormSignature.store({
                    project_id: this.project_id,
                    form_id: this.form_id,
                    insured_signature: this.ownerSignaturePng,
                    company_signature: this.companySignaturePng
                })
                    .then(res => {
                    }).catch(this.handleErrorResponse)
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
                }
                return projectForms.length > 0 ? projectForms[0] : null
            },
            isLoaded: function() {
                return this.$store.state.User.company.length !== 0 && this.$store.state.ProjectForm.callReport && this.projectFormPerID
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .signature {
        border-bottom: 1px solid black;
    }
</style>