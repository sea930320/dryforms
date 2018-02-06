<template>
    <div class="equipment-add">
        <div v-if="isLoaded" class="card text-center">
            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-container class="">
                    <b-row>
                        <div class="form-group col-md-6">
                            <label>Category</label>
                            <select class="form-control" v-model="data.category_id">
                                <option :value="null">-- Please select --</option>
                                <option v-for="item in categories" v-bind:key="item.id" :value="item.id">{{ item.name
                                    }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Add New Category</label>
                            <form data-vv-scope="form-category">
                                <b-row>
                                    <b-col cols="8">
                                        <input type="text" name="category" class="form-control"
                                               :class="{'is-invalid': (errors.has('category') || validateCategory) && !data.category_id}"
                                               v-validate data-vv-rules="required" v-model="newCategory"
                                               :disabled="data.category_id" placeholder="Category">
                                    </b-col>
                                    <b-col cols="4">
                                        <input type="text" name="prefix" class="form-control"
                                               :class="{'is-invalid': errors.has('prefix') && !data.category_id}"
                                               v-validate data-vv-rules="required" v-model="newPrefix"
                                               :disabled="data.category_id" placeholder="Prefix">
                                    </b-col>
                                </b-row>
                            </form>
                        </div>
                    </b-row>
                    <b-row>
                        <div class="form-group col-md-6">
                            <label>Make/Model</label>
                            <select class="form-control" v-model="data.model_id">
                                <option :value="null">-- Please select --</option>
                                <option v-for="item in models" v-bind:key="item.id" :value="item.id">{{ item.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Add New Make/Model</label>
                            <form data-vv-scope="form-model">
                                <input type="text" name="model" class="form-control"
                                       :class="{'is-invalid': (errors.has('model') || validateModel) && !data.model_id}"
                                       v-validate data-vv-rules="required" v-model="newModel" :disabled="data.model_id"
                                       placeholder="Make/Model">
                            </form>
                        </div>
                    </b-row>
                    <b-row>
                        <div class="form-group col-md-6">
                            <label>Crew/Team</label>
                            <select class="form-control" v-model="data.team_id">
                                <option :value="null">-- Please select --</option>
                                <option v-for="item in teams" v-bind:key="item.id" :value="item.id">{{ item.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <form data-vv-scope="form-global">
                                <label>Statuses</label>
                                <select class="form-control" v-model="data.status_id" name="status"
                                        :class="{'is-invalid': errors.has('status')}" v-validate
                                        data-vv-rules="required">
                                    <option :value="null">-- Please select --</option>
                                    <option v-for="item in statuses" v-bind:key="item.id" :value="item.id">{{ item.name
                                        }}
                                    </option>
                                </select>
                            </form>
                        </div>
                    </b-row>
                    <b-card bg-variant="light" class="mt-1 mb-2 pt-0">
                        <b-row>
                            <b-col cols="3">
                                <form data-vv-scope="form-global">
                                    <b-form-group id="fieldsetHorizontal"
                                                  horizontal
                                                  :label-cols="4"
                                                  :label-size="template_size"
                                                  label="Quantity"
                                                  label-for="inputQuantity"
                                                  class="m-0">
                                        <b-form-input id="inputQuantity" name="inputQuantity" type="number"
                                                      placeholder="Enter the quantity" :size="template_size"
                                                      :class="{'is-invalid': errors.has('inputQuantity')}" v-validate
                                                      data-vv-rules="required" v-model="data.quantity" min=1
                                                      :disabled="isBusy"></b-form-input>
                                    </b-form-group>
                                </form>
                            </b-col>
                            <b-col cols="8">
                                <b-form-checkbox v-model="data.auto_assign" value="yes" unchecked-value="no"
                                                 :size="template_size" class="m-0">
                                    Assign Equipment Numbers Automatically?
                                </b-form-checkbox>
                            </b-col>
                        </b-row>
                        <b-row v-if="data.auto_assign === 'no' && data.quantity > 0">
                            <b-col cols="12">
                                <hr>
                                <b-row>
                                    <b-col cols="8">
                                        <label>Equipment #</label>
                                    </b-col>
                                    <b-col cols="4" class="pt-2 mb-1">
                                        <b-form-group horizontal :label-cols="4" label-text-align="right"
                                                      label="<b>Page Size:</b>" :label-size="template_size"
                                                      class="p-0 m-0">
                                            <b-input-group :size="template_size">
                                                <b-form-input type="number" placeholder="Row" min="1" max="6"
                                                              v-model="perRow" :disabled="isBusy"></b-form-input>
                                                <b-input-group-addon>×</b-input-group-addon>
                                                <b-form-input type="number" placeholder="Column" min="1"
                                                              v-model="perCol" :disabled="isBusy"></b-form-input>
                                            </b-input-group>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col cols="12">
                                <b-table ref="serialsTable" :busy.sync="isBusy" :items="getCurEquipmentNumbers" small
                                         striped hover fixed :fields="fieldArray" :current-page="currentPage"
                                         :per-page="perPage" head-variant="">
                                    <template v-for="field in fieldArray" v-if="row.item[field]" :slot="field"
                                              slot-scope="row">
                                        <b-input-group v-bind:key="field">
                                            <b-form-input type="number" min=0
                                                          v-model.lazy.trim="row.item[field]['value']"
                                                          :disabled="isBusy"
                                                          @input="validateSerial(row.item[field])"></b-form-input>
                                            <b-input-group-button>
                                                <b-button :variant="row.item[field]['validate']?'success':'danger'"
                                                          @click="reason(row.item[field])" style="width: 38px">
                                                    <i v-if="row.item[field]['validate']" class="fa fa-check"></i>
                                                    <i v-else class="fa fa-exclamation-triangle"></i>
                                                </b-button>
                                            </b-input-group-button>
                                        </b-input-group>
                                    </template>
                                </b-table>
                                <div class="justify-content-center row-margin-tweak row">
                                    <b-pagination v-if="!isBusy" :size="template_size" :total-rows="count"
                                                  :per-page="perPage" limit="5" v-model="currentPage"/>
                                    <div v-else>...</div>
                                </div>
                            </b-col>
                        </b-row>
                    </b-card>
                    <b-btn class="float-right" variant="" :size="template_size" @click="initData">Clear</b-btn>
                    <b-btn class="float-right mr-3" :size="template_size" variant="primary" @click="addEquip">Add
                    </b-btn>
                </b-container>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
        <loading v-else></loading>
        <b-modal v-model="resultModal.show" centered :title="resultModal.modalTitle"
                 header-bg-variant="dark"
                 header-text-variant="light"
                 body-bg-variant="light"
                 body-text-variant="dark"
                 footer-bg-variant="dark"
                 footer-text-variant="light">
            <p class="float-left mb-1">{{resultModal.msg}}</p>
            <p class="float-left mb-0" v-if="resultModal.success">Would you like to check the archived equipments?</p>
            <div slot="modal-footer">
                <b-btn :size="template_size" class="float-right" variant="" @click="initData">
                    {{resultModal.success ? "No": "Close"}}
                </b-btn>
                <b-btn v-if="resultModal.success" :size="template_size" class="float-right mr-3" variant="primary"
                       @click="showEquipments">
                    Yes
                </b-btn>
            </div>
        </b-modal>
    </div>
</template>

<script type="text/babel">
    import {mapActions, mapGetters} from 'vuex'
    import Loading from '../layout/Loading'
    import _ from 'lodash'

    import apiCategories from '../../api/categories'
    import apiModels from '../../api/models'
    import apiTeams from '../../api/teams'
    import apiStatuses from '../../api/statuses'
    import apiEquipment from '../../api/equipment'
    import ErrorHandler from '../../mixins/error-handler'

    export default {
        mixins: [ErrorHandler],
        name: 'add-equip-modal',
        components: {Loading},
        data() {
            return {
                isLoaded: false,
                categories: [],
                models: [],
                statuses: [],
                teams: [],
                data: {
                    model_id: null,
                    category_id: null,
                    team_id: null,
                    status_id: null,
                    quantity: 1,
                    auto_assign: 'yes',
                    serials: [{
                        value: '',
                        validate: false
                    }]
                },
                newModel: '',
                newCategory: '',
                newPrefix: '',
                isBusy: false,
                currentPage: 1,
                perRow: 2,
                perCol: 3,
                count: 0,
                resultModal: {
                    show: false,
                    modalTitle: 'Success',
                    success: false,
                    msg: '',
                    id_from: null
                }
            }
        },
        mounted() {
            this.fetchUser()
        },
        created() {
            this.$nextTick(() => {
                this.getList()
            })
            this.$on('reloadData', () => {
                this.getList()
            })
        },
        computed: {
            ...mapGetters({
                company_id: 'companyId',
                user_id: 'userId'
            }),
            fieldArray: function () {
                let fields = []
                for (let i = 0; i < this.perRow; i++) {
                    fields.push('col-' + i)
                }
                return fields
            },
            perPage: function () {
                return this.perRow * this.perCol
            },
            validateModel: function () {
                if (!this.models) return false
                if (this.models.some(model => model.name === this.newModel)) {
                    return true
                }
                return false
            },
            validateCategory: function () {
                if (!this.categories) return false
                if (this.categories.some(category => category.name === this.newCategory)) {
                    return true
                }
                return false
            }
        },
        watch: {
            'data.quantity': function (newVal) {
                let oldVal = this.data.serials.length || 0
                if (parseInt(newVal) > parseInt(oldVal)) {
                    for (let i = oldVal; i < newVal; i++) {
                        this.data.serials.push({
                            value: '',
                            validate: false
                        })
                    }
                } else {
                    this.data.serials = this.data.serials.slice(0, newVal)
                }
                this.count = newVal
                if (this.data.auto_assign === 'no' && this.data.quantity > 0 && this.$refs.serialsTable) {
                    this.$refs.serialsTable.refresh()
                }
            },
            'data.category_id': function (val) {
                if (!val) {
                    this.data.model_id = null
                    this.models = []
                } else {
                    apiModels.index({category_id: val})
                        .then(response => {
                            this.models = response.data.data
                            this.data.model_id = null
                        })
                }
                this.errors.clear('form-category')
                if (val !== null) {
                    this.newCategory = ''
                    this.newPrefix = ''
                }
            },
            'data.model_id': function (val) {
                this.errors.clear('form-model')
                if (val !== null) {
                    this.newModel = ''
                }
            },
            'resultModal.show': function (val) {
                if (val === false) {
                    this.initData()
                }
            }
        },
        methods: {
            ...mapActions([
                'getCompany',
                'fetchUser'
            ]),
            getList() {
                const data = [
                    apiCategories.index(),
                    apiStatuses.index(),
                    apiTeams.index()
                ]

                return Promise.all(data)
                    .then(response => {
                        this.categories = response[0].data.data
                        this.statuses = response[1].data.data
                        this.teams = response[2].data.data
                        this.isLoaded = true
                        return response
                    })
            },
            getCurEquipmentNumbers(ctx) {
                this.count = this.data.quantity
                let serials = (ctx.currentPage * ctx.perPage > this.count) ? this.data.serials.slice(ctx.perPage * (ctx.currentPage - 1)) : this.data.serials.slice(ctx.perPage * (ctx.currentPage - 1), ctx.perPage * ctx.currentPage)
                let serialGroup = []
                let self = this
                serials.forEach(function (serial, index) {
                    let colLabel = 'col-' + index % self.perRow
                    serialGroup[parseInt(index / self.perRow)] = serialGroup[parseInt(index / self.perRow)] || []
                    serialGroup[parseInt(index / self.perRow)][colLabel] = serial
                })
                return serialGroup
            },
            validateSerial: _.debounce(function (equipment) {
                let serial = equipment['value']
                if (!serial) {
                    equipment['validate'] = false
                    equipment['reason'] = 'Please Input Serial Number'
                    return false
                }
                if (!this.data.category_id && (!this.newCategory || !this.newPrefix)) {
                    equipment['reason'] = 'Please input valid category'
                    equipment['validate'] = false
                    return false
                }
                if (!this.data.category_id && (this.newCategory && this.newPrefix)) {
                    if (this.categories.some(category => category.name === this.newCategory)) {
                        equipment['reason'] = 'Please input valid category'
                        equipment['validate'] = false
                        return false
                    }
                    equipment['validate'] = true
                    equipment['reason'] = 'Valid Serial Number'
                    return true
                }
                return apiEquipment.valdiateSerial(serial, this.data.category_id)
                    .then(response => {
                        if (response.data.message === 'exist') {
                            equipment['validate'] = false
                            equipment['reason'] = 'Serial number alreday exists'
                            return false
                        }
                        if (response.data.message === 'serial is not numeric') {
                            equipment['validate'] = false
                            equipment['reason'] = 'Serial number is not numeric'
                            return false
                        }
                        equipment['validate'] = true
                        return true
                    }).catch(err => {
                        if (err) {
                            equipment['validate'] = false
                            equipment['reason'] = 'Please check network state'
                            return false
                        }
                    })
            }, 500),
            reason(equipment) {
                if (!equipment['validate']) {
                    let msg = equipment['reason'] ? equipment['reason'] : 'Please Input Serial Number'
                    this.errorSerialValidate(msg)
                    return
                }
                this.$notify({
                    type: 'success',
                    title: 'Valid Serial Number',
                    text: 'You can use this serial number'
                })
            },
            addEquip() {
                if (!this.data.category_id || !this.data.model_id) {
                    if (this.data.category_id) {
                        this.$validator.validateAll('form-model')
                    } else if (this.data.model_id) {
                        this.$validator.validateAll('form-category')
                    } else {
                        this.$validator.validateAll()
                    }
                    if (this.errors.any()) {
                        return
                    }
                }
                this.$validator.validateAll('form-global')
                if (this.errors.any()) {
                    return
                }

                if (this.data.auto_assign === 'no') {
                    for (let i = 0; i < this.data.serials.length; i++) {
                        let serial = this.data.serials[i]
                        if (!serial.value) {
                            this.errorSerialValidate('You must enter all serial numbers')
                            return
                        }
                        if (!serial.validate) {
                            this.errorSerialValidate('Please enter validate serial numbers')
                            return
                        }
                    }
                }

                let self = this
                this.data.company_id = this.company_id

                var saveEquipment = function () {
                    let payload = Object.assign({}, self.data)
                    if (self.data.auto_assign === 'yes') {
                        delete payload.serials
                    }
                    return apiEquipment.store(payload)
                        .then(response => {
                            if (response.data.message === 'error') {
                                let validate = response.data.validate.serials || {
                                    exists: [],
                                    nonexistences: []
                                }
                                if (validate.exists.length !== 0) {
                                    self.errorSerialValidate('Some serial numbers already exist')
                                }
                            } else {
                                self.resultModal = {
                                    show: true,
                                    success: true,
                                    modalTitle: 'Success',
                                    msg: response.data.message,
                                    id_from: response.data.equipment[0].id
                                }
                            }
                        }).catch(self.handleErrorResponse)
                }
                var saveModel = function () {
                    return apiModels.store({
                        name: self.newModel,
                        category_id: self.data.category_id,
                        company_id: self.company_id
                    }).then(response => {
                        if (response.data.message) {
                            self.data.model_id = response.data.model.id
                            self.models.push({
                                id: response.data.model.id,
                                name: response.data.model.name
                            })
                            return saveEquipment()
                        }
                    }).catch(self.handleErrorResponse)
                }

                if (!this.data.category_id) {
                    return apiCategories.store({
                        name: this.newCategory,
                        prefix: this.newPrefix,
                        company_id: this.company_id
                    }).then(response => {
                        self.data.category_id = response.data.category.id
                        self.categories.push({
                            id: response.data.category.id,
                            name: response.data.category.name
                        })
                        if (!self.data.model_id) {
                            return saveModel()
                        }
                        return saveEquipment()
                    }).catch(self.handleErrorResponse)
                }
                if (!self.data.model_id) {
                    return saveModel()
                }
                return saveEquipment()
            },
            showEquipments() {
                this.$router.push({
                    name: 'Equipment Detail',
                    params: {
                        category_id: this.data.category_id,
                        model_id: this.data.model_id,
                        status_id: this.data.status_id
                    },
                    query: {
                        id_from: this.resultModal.id_from
                    }
                })
            },
            initData() {
                this.data = {
                    model_id: null,
                    category_id: null,
                    team_id: null,
                    status_id: null,
                    quantity: 1,
                    auto_assign: 'yes',
                    serials: [{
                        value: '',
                        validate: false
                    }]
                }
                this.resultModal = {
                    show: false,
                    success: false,
                    msg: '',
                    id_from: null
                }
                this.errors.clear()
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    .equipment-add {
        .custom-control .custom-control-indicator {
            top: .45rem !important;
        }
        thead {
            display: none;
        }
        table {
            .btn {
                padding: .375rem 0rem !important;
            }
        }
    }

    .input-group-addon {
        font-size: 1rem;
        line-height: 2rem;
    }
</style>
