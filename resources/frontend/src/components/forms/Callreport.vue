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
                                <b-form-checkbox :value="item.value" @change="save()">{{ item.text }}</b-form-checkbox>
                            </b-col>
                        </b-row>
                    </b-form-checkbox-group>
                    <div v-for="item in inputGroup1" :key="item.label">
                        <label>{{ item.label }}</label>
                        <div v-if="item.type==='phone'">                            
                            <masked-input @input="save()" class="form-control" v-model="formModel1[item.model]" mask="(111) 111-1111" placeholder="(702) 555-1212"/>
                        </div>
                        <div v-else-if="item.type==='date'">
                            <date-picker v-model="formModel1[item.model]" type="date" format="yyyy-MM-dd" lang="en" @input="changeDate(formModel1, item.model)" style="width: 100%"></date-picker>
                        </div>
                        <div v-else-if="item.type==='time'">
                            <!-- <datetime v-model="formModel1[item.model]" format="h:i:s"></datetime> -->
                        </div>
                        <div v-else>
                            <b-form-input @input="save()" v-model="formModel1[item.model]"></b-form-input>
                        </div>
                    </div>
                    <b-form-checkbox-group v-model="selectedJobType" class="mt-3 mb-3">
                        <b-row>
                            <b-col v-for="item in jobTypes" :key="item.value" class="col-md-6">
                                <b-form-checkbox :value="item.value" @change="save()">{{ item.text }}</b-form-checkbox>
                            </b-col>
                        </b-row>
                    </b-form-checkbox-group>
                    <div v-for="item in inputGroup2" :key="item.label">
                        <div v-if="item.type!=='phone'">
                            <label>{{ item.label }}</label>
                            <b-form-input v-model="formModel2[item.model]" @input="save()"></b-form-input>
                        </div>
                        <div v-else>
                            <label>{{ item.label }}</label>
                            <masked-input class="form-control" v-model="formModel2[item.model]" mask="(111) 111-1111" placeholder="(702) 555-1212" @input="save()"/>
                        </div>
                    </div>
                    <div>
                        <label> Assigned to: </label>
                        <select class="form-control" v-model="assignee.id" v-if="assignee" @change="save()">
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
                        <b-form-checkbox @change="save()" v-model="sameJobAddress" v-if="item.model == 'billingAddress'" id="copy_address">Same
                            as job address
                        </b-form-checkbox>
                        <b-form-checkbox @change="save()" v-model="sameContactName" v-if="item.model == 'insuredName'" id="copy_name">Same
                            as contact name
                        </b-form-checkbox>
                        <div v-if="item.type!=='phone'">
                            <b-form-input @input="save()" v-model="formModel3[item.model]"></b-form-input>
                        </div>
                        <div v-else>
                            <masked-input @input="save()" class="form-control" v-model="formModel3[item.model]" mask="(111) 111-1111" placeholder="(702) 555-1212"/>
                        </div>
                    </div>
                    <b-row>
                        <b-col class="text-center"><h5>Insurance Information</h5></b-col>
                    </b-row>
                    <div v-for="item in inputGroup4" :key="item.label">
                        <label>{{ item.label }}</label>
                        <div v-if="item.type!=='phone'">
                            <b-form-input @input="save()" v-model="formModel4[item.model]"></b-form-input>
                        </div>
                        <div v-else>
                            <masked-input @input="save()" class="form-control" v-model="formModel4[item.model]" mask="(111) 111-1111" placeholder="(702) 555-1212"/>
                        </div>
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

    import MaskedInput from 'vue-masked-input'
    import DatePicker from 'vue2-datepicker'
    import _ from 'lodash'

    export default {
        mixins: [ErrorHandler],
        components: {FormHeader, Notes, MaskedInput, DatePicker},
        props: ['title'],
        data() {
            return {
                projectId: null,
                formId: null,
                callReport: null,
                assignee: null,
                project: null,
                teams: [],
                isLoaded: false,
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
                    {label: 'Contact Phone:', model: 'contactPhone', type: 'phone'},
                    {label: 'Site Phone:', model: 'sitePhone', type: 'phone'},
                    {label: 'Date Contacted:', model: 'dateContacted', type: 'date'},
                    // {label: 'Time Contacted:', model: 'timeContacted', type: 'time'},
                    {label: 'Date of Loss:', model: 'dateLoss', type: 'date'},
                    {label: 'Point of Loss:', model: 'pointLoss'},
                    {label: 'Date Completed:', model: 'dateCompleted', type: 'date'}
                ],
                formModel1: {
                    contactName: null,
                    contactPhone: null,
                    sitePhone: null,
                    dateContacted: null,
                    // timeContacted: null,
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
                    {label: 'Home Phone:', model: 'insuredHomePhone', type: 'phone'},
                    {label: 'Cell Phone:', model: 'insuredCellPhone', type: 'phone'},
                    {label: 'Work Phone:', model: 'insuredWorkPhone', type: 'phone'},
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
                    {label: 'Work Phone:', model: 'insuranceWorkPhone', type: 'phone'},
                    {label: 'Cell Phone:', model: 'insuranceCellPhone', type: 'phone'},
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
                },
                timeConfig: {
                    format: 'hh:mm:ss',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                    keepOpen: true,
                    debug: true
                },
                dateConfig: {
                    format: 'YYYY/MM/D ',
                    useCurrent: false,
                    showClear: true,
                    showClose: true,
                    keepOpen: true
                }
            }
        },
        created() {
            this.projectId = this.$route.params.project_id
            this.formId = this.$route.params.form_id
            // this.$bus.$on('forms_save', this.save)
            this.init()
        },
        beforeDestroy () {
            // this.$bus.$off('forms_save', this.save)
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
                    this.isLoaded = true
                    this.teams = res[1].data.data
                    if (res[0].data.length === 0) {
                        this.assignee = {
                            id: null
                        }
                        return
                    }
                    let resData = Object.entries(res[0].data[0])
                    this.callReport = res[0].data[0]

                    this.project = this.callReport.project ? this.callReport.project : null
                    this.assignee = this.callReport.assignee ? this.callReport.assignee : {
                        id: null
                    }
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
            save: _.debounce(function () {
                if (!this.isLoaded) return
                // if (formName !== 'Form Call Report') return
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
                        // this.$notify({
                        //     type: 'success',
                        //     text: res.data.message
                        // })
                    }).catch(this.handleErrorResponse)
                } else {
                    apiProjectCallReports.patch(this.callReport.id, finalCallReport).then((res) => {
                        // this.$notify({
                        //     type: 'success',
                        //     text: res.data.message
                        // })
                    }).catch(this.handleErrorResponse)
                }
            }, 500),
            changeDate(formModel1, model) {
                if (formModel1[model]) {
                    var date = new Date(formModel1[model])
                    formModel1[model] = date.getFullYear() + '-' + (date.getMonth() < 10 ? '0' + date.getMonth() : date.getMonth()) + '-' + (date.getDate() < 10 ? '0' + date.getDate() : date.getDate())
                }
                this.save()
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
