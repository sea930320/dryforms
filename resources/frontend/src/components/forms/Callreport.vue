<template>
    <div class="card mb-3">
        <div class="card-body text-center">
            <form-header></form-header>
            <h4 class="mb-2">{{ title }}</h4>
            <div class="dropdown-divider"></div>
            <b-row>
                <b-col class="text-left">
                    <b-row>
                        <b-col class="text-center"><h5>Job Site</h5></b-col>
                    </b-row>
                    <b-form-checkbox-group v-model="selectedCustomerType" class="mt-3 mb-3">
                        <b-row>
                            <b-col v-for="item in customerTypes" :key="item.value" class="col-md-6">
                                <b-form-checkbox :value="item.value">{{ item.text }}</b-form-checkbox>
                            </b-col>
                        </b-row>
                    </b-form-checkbox-group>
                    <div v-for="item in inputGroup1" :key="item.label">
                        <label>{{ item.label }}</label>
                        <b-form-input v-model="formModel1[item.model]"></b-form-input>
                    </div>
                    <b-form-checkbox-group v-model="selectedJobType" class="mt-3 mb-3">
                        <b-row>
                            <b-col v-for="item in jobTypes" :key="item.value" class="col-md-6">
                                <b-form-checkbox :value="item.value">{{ item.text }}</b-form-checkbox>
                            </b-col>
                        </b-row>
                    </b-form-checkbox-group>
                    <div v-for="item in inputGroup2" :key="item.label">
                        <label>{{ item.label }}</label>
                        <b-form-input v-model="formModel2[item.model]"></b-form-input>
                    </div>
                    <div>
                        <label> Assigned to: </label>
                        <select class="form-control" v-model="assignee.id" v-if="assignee">
                            <option :value="null">-- Please select --</option>
                            <option v-for="item in teams" v-bind:key="item.id" :value="item.id">{{ item.name }}
                            </option>
                        </select>
                    </div>
                </b-col>
                <b-col class="text-left">
                    <b-row class="mt-2">
                        <b-col class="text-center"><h5>Owner/Insured Information</h5></b-col>
                    </b-row>
                    <div v-for="item in inputGroup3" :key="item.label">
                        <label>{{ item.label }}</label>
                        <b-form-checkbox v-model="sameJobAddress" v-if="item.model == 'billingAddress'" id="copy_address">Same
                            as job address
                        </b-form-checkbox>
                        <b-form-checkbox v-model="sameContactName" v-if="item.model == 'insuredName'" id="copy_name">Same
                            as contact name
                        </b-form-checkbox>
                        <b-form-input v-model="formModel3[item.model]"></b-form-input>
                    </div>
                    <b-row>
                        <b-col class="text-center"><h5>Insurance Information</h5></b-col>
                    </b-row>
                    <div v-for="item in inputGroup4" :key="item.label">
                        <label>{{ item.label }}</label>
                        <b-form-input v-model="formModel4[item.model]"></b-form-input>
                    </div>
                </b-col>
            </b-row>
            <notes></notes>
        </div>
    </div>
</template>

<script type="text/babel">
    import FormHeader from './FormHeader'
    import Notes from './Notes'
    import ErrorHandler from '../../mixins/error-handler'
    import apiProjectCallReports from '../../api/project_call_reports'
    import apiTeams from '../../api/teams'
    import _ from 'lodash'

    export default {
        mixins: [ErrorHandler],
        components: {FormHeader, Notes},
        props: ['title'],
        data() {
            return {
                projectId: null,
                formId: null,
                callReport: null,
                assignee: null,
                project: null,
                teams: [],
                customerTypes: [
                    {text: 'Residential', value: 'is_residential'},
                    {text: 'Commercial', value: 'is_commercial'},
                    {text: 'Owner/Insured', value: 'is_insured'},
                    {text: 'Tenant', value: 'is_tenant'}
                ],
                customerTypesMatch: {
                    isResidential: 'is_residential',
                    isCommercial: 'is_commercial',
                    isInsured: 'is_insured',
                    isTenant: 'is_tenant'
                },
                selectedCustomerType: [],
                inputGroup1: [
                    {label: 'Contact Name:', model: 'contactName'},
                    {label: 'Contact Phone:', model: 'contactPhone'},
                    {label: 'Site Phone:', model: 'sitePhone'},
                    {label: 'Date Contacted:', model: 'dateContacted'},
                    {label: 'Time Contacted:', model: 'timeContacted'},
                    {label: 'Date of Loss:', model: 'dateLoss'},
                    {label: 'Point of Loss:', model: 'pointLoss'},
                    {label: 'Date Completed:', model: 'dateCompleted'}
                ],
                formModel1: {
                    contactName: null,
                    contactPhone: null,
                    sitePhone: null,
                    dateContacted: null,
                    timeContacted: null,
                    dateLoss: null,
                    pointLoss: null,
                    dateCompleted: null
                },
                jobTypes: [
                    {text: 'Water', value: 'is_water'},
                    {text: 'Sewage', value: 'is_sewage'},
                    {text: 'Mold', value: 'is_mold'},
                    {text: 'Fire', value: 'is_fire'}
                ],
                jobTypesMatch: {
                    isWater: 'is_water',
                    isSewage: 'is_sewage',
                    isMold: 'is_mold',
                    isFire: 'is_fire'
                },
                selectedJobType: [],
                inputGroup2: [
                    {label: 'Category:', model: 'category'},
                    {label: 'Class:', model: 'class'},
                    {label: 'Job Address:', model: 'jobAddress'},
                    {label: 'City:', model: 'city'},
                    {label: 'State:', model: 'state'},
                    {label: 'Zip Code:', model: 'zipCode'},
                    {label: 'Cross Streets:', model: 'crossStreets'},
                    {label: 'Apartment Name:', model: 'apartmentName'},
                    {label: 'Building #', model: 'buildingNo'},
                    {label: 'Apartment #', model: 'apartmentNo'},
                    {label: 'Gate Code:', model: 'gateCode'}
                ],
                formModel2: {
                    category: null,
                    class: null,
                    jobAddress: null,
                    city: null,
                    state: null,
                    zipCode: null,
                    crossStreets: null,
                    apartmentName: null,
                    buildingNo: null,
                    apartmentNo: null,
                    gateCode: null
                },
                sameJobAddress: false,
                sameContactName: false,
                inputGroup3: [
                    {label: 'Owner/Insured Name:', model: 'insuredName'},
                    {label: 'Billing Address:', model: 'billingAddress'},
                    {label: 'City:', model: 'insuredCity'},
                    {label: 'State:', model: 'insuredState'},
                    {label: 'Zip Code:', model: 'insuredZipCode'},
                    {label: 'Home Phone:', model: 'insuredHomePhone'},
                    {label: 'Cell Phone:', model: 'insuredCellPhone'},
                    {label: 'Work Phone:', model: 'insuredWorkPhone'},
                    {label: 'Email:', model: 'insuredEmail'},
                    {label: 'Fax:', model: 'insuredFax'}
                ],
                formModel3: {
                    insuredName: null,
                    billingAddress: null,
                    insuredCity: null,
                    insuredState: null,
                    insuredZipCode: null,
                    insuredHomePhone: null,
                    insuredCellPhone: null,
                    insuredWorkPhone: null,
                    insuredEmail: null,
                    insuredFax: null
                },
                inputGroup4: [
                    {label: 'Claim #', model: 'insuranceClaimNo'},
                    {label: 'Insurance Company:', model: 'insuranceCompany'},
                    {label: 'Policy #', model: 'insurancePolicyNo'},
                    {label: 'Deductible:', model: 'insuranceDeductible'},
                    {label: 'Insurance Adjuster:', model: 'insuranceAdjuster'},
                    {label: 'Address', model: 'insuranceAddress'},
                    {label: 'City:', model: 'insuranceCity'},
                    {label: 'State:', model: 'insuranceState'},
                    {label: 'Zip Code:', model: 'insuranceZipCode'},
                    {label: 'Work Phone:', model: 'insuranceWorkPhone'},
                    {label: 'Cell Phone:', model: 'insuranceCellPhone'},
                    {label: 'Email:', model: 'insuranceEmail'},
                    {label: 'Fax:', model: 'insuranceFax'}
                ],
                formModel4: {
                    insuranceClaimNo: null,
                    insuranceCompany: null,
                    insurancePolicyNo: null,
                    insuranceDeductible: null,
                    insuranceAdjuster: null,
                    insuranceAddress: null,
                    insuranceCity: null,
                    insuranceState: null,
                    insuranceZipCode: null,
                    insuranceWorkPhone: null,
                    insuranceCellPhone: null,
                    insuranceEmail: null,
                    insuranceFax: null
                }
            }
        },
        created() {
            this.projectId = this.$route.params.project_id
            this.formId = this.$route.params.form_id
            this.$bus.$on('forms_save', this.save)
            this.init()
        },
        beforeDestroy () {
            this.$bus.$off('forms_save', this.save)
        },
        methods: {
            init() {
                const apis = [
                    apiProjectCallReports.index({
                        project_id: this.projectId
                    }),
                    apiTeams.index()
                ]
                Promise.all(apis).then(res => {
                    this.teams = res[1].data.data
                    if (res[0].data.length === 0) {
                        this.assignee = {
                            id: null
                        }
                        return
                    }
                    let resData = Object.entries(res[0].data[0])
                    this.callReport = res[0].data[0]

                    this.project = this.callReport.project
                    this.assignee = this.callReport.assignee
                    let self = this
                    resData.forEach(function(field) {
                        let fieldKey = _.camelCase(field[0])
                        let fieldValue = field[1]
                        if (_.has(self.formModel1, fieldKey)) {
                            self.formModel1[fieldKey] = fieldValue
                        }
                        if (_.has(self.formModel2, fieldKey)) {
                            self.formModel2[fieldKey] = fieldValue
                        }
                        if (_.has(self.formModel3, fieldKey)) {
                            self.formModel3[fieldKey] = fieldValue
                        }
                        if (_.has(self.formModel4, fieldKey)) {
                            self.formModel4[fieldKey] = fieldValue
                        }
                        if (_.has(self.customerTypesMatch, fieldKey)) {
                            if (fieldValue) {
                                self.selectedCustomerType.push(self.customerTypesMatch[fieldKey])
                            }
                        }
                        if (_.has(self.jobTypesMatch, fieldKey)) {
                            if (fieldValue) {
                                self.selectedJobType.push(self.jobTypesMatch[fieldKey])
                            }
                        }
                    })
                })
            },
            save(formName) {
                if (formName !== 'Form Call Report') return
                let callReportObject = Object.assign({}, this.formModel1, this.formModel2, this.formModel3, this.formModel4)
                let callReportArray = Object.entries(callReportObject)
                let finalCallReport = {}
                callReportArray.forEach(function(field) {
                    let fieldKey = _.snakeCase(field[0])
                    let fieldValue = field[1]
                    finalCallReport[fieldKey] = fieldValue
                })
                finalCallReport.assigned_to = this.assignee.id
                this.customerTypes.forEach((field) => {
                    if (this.selectedCustomerType.indexOf(field.value) > -1) {
                        finalCallReport[field.value] = 1
                    } else {
                        finalCallReport[field.value] = 0
                    }
                })
                this.jobTypes.forEach((field) => {
                    if (this.selectedJobType.indexOf(field.value) > -1) {
                        finalCallReport[field.value] = 1
                    } else {
                        finalCallReport[field.value] = 0
                    }
                })
                finalCallReport.project_id = this.projectId
                finalCallReport.company_id = this.company.id

                if (this.callReport === null) {
                    apiProjectCallReports.store(finalCallReport).then((res) => {
                        this.assignee = res.data.projectCallReport.assignee ? res.data.projectCallReport.assignee : {
                            id: null
                        }
                        this.callReport = res.data.projectCallReport
                        this.project = res.data.projectCallReport.project ? res.data.projectCallReport.project : null
                        this.$notify({
                            type: 'success',
                            text: res.data.message
                        })
                    }).catch(this.handleErrorResponse)
                } else {
                    apiProjectCallReports.patch(this.callReport.id, finalCallReport).then((res) => {
                        this.$notify({
                            type: 'success',
                            text: res.data.message
                        })
                    }).catch(this.handleErrorResponse)
                }
            }
        },
        watch: {
            sameJobAddress: function () {
                if (this.sameJobAddress) {
                    this.formModel3.billingAddress = this.formModel2.jobAddress
                    this.formModel3.insuredCity = this.formModel2.city
                    this.formModel3.insuredState = this.formModel2.state
                    this.formModel3.insuredZipCode = this.formModel2.zipCode
                } else {
                    this.formModel3.billingAddress = ''
                    this.formModel3.insuredCity = ''
                    this.formModel3.insuredState = ''
                    this.formModel3.insuredZipCode = ''
                }
            },
            sameContactName: function () {
                if (this.sameContactName) {
                    this.formModel3.insuredName = this.formModel1.contactName
                } else {
                    this.formModel3.insuredName = ''
                }
            }
        },
        computed: {
            projectFormPerID: function() {
                let projectForms = this.$store.getters.projectFormPerID(this.formId)
                return projectForms.length > 0 ? projectForms[0] : null
            },
            company: function() {
                return this.$store.state.User.company
            }
        }
    }
</script>