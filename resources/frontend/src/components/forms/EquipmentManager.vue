<template>
  <b-modal title="Equipment Manager" v-model="showModal" v-if="isLoaded">
    <div class="equipment-detail">
        <div class="card text-center">
            <div class="card-body text-left pt-3 pb-3">
                <b-container>
                    <b-row align-h="between" class="mr-0 ml-0">
                        <b-col cols="6">
                            <b-card bg-variant="light" class="mt-1 mb-1 pt-0">
                                <b-form-group vertical :label-cols="3" label-text-align="left" label="<b>Filter:</b>"
                                              :label-size="template_size" class="m-0 p-0">
                                    <b-input-group :size="template_size">
                                        <b-form-input v-model="filter" placeholder="Type text" :disabled="isBusy"/>
                                        <b-input-group-button>
                                            <b-btn :size="template_size" :disabled="!filter || isBusy"
                                                   @click="filter = ''">Clear
                                            </b-btn>
                                        </b-input-group-button>
                                    </b-input-group>
                                </b-form-group>
                            </b-card>
                        </b-col>
                        <b-col cols="2">
                            <b-card bg-variant="light" class="mt-1 mb-1 pt-0">
                                <b-form-group vertical :label-cols="3" label-text-align="left" label="<b>Page Size:</b>"
                                              :label-size="template_size" class="p-0 m-0">
                                    <b-form-select :size="template_size" :disabled="isBusy" class="form-control"
                                                   :options="pageSizeOption" v-model="perPage">
                                    </b-form-select>
                                </b-form-group>
                            </b-card>
                        </b-col>
                    </b-row>
                </b-container>
                <b-table ref="DetailTable" :busy.sync="isBusy" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc"
                         :items="getEquipment" small striped hover foot-clone :fields="fields"
                         :current-page="currentPage" :per-page="perPage" :filter="fiter_debouncer" head-variant=""
                         align-v="center">
                    <template slot="category_name" slot-scope="row">
                        {{row.item.model.category.name ? row.item.model.category.name : 'n/a'}}
                    </template>
                    <template slot="make_model" slot-scope="row">
                        {{row.item.model.name}}
                    </template>
                    <template slot="serial" slot-scope="row">
                        {{row.item.serial.number}}
                    </template>
                    <template slot="location" slot-scope="row">
                        {{row.item.location}}
                    </template>
                    <template slot="team" slot-scope="row">
                        {{row.item.team.name}}
                    </template>
                    <template slot="status" slot-scope="row">
                        {{row.item.status.name}}
                        <b-dropdown variant="link" right size="xs" no-caret class="pull-right">
                            <template slot="button-content">
                                <i class="fa fa-pencil"></i>
                            </template>
                            <b-dropdown-item v-for="status in statuses" :key="status.id"
                                             @click="changeStatus(row.item, status.id)">
                          <span v-if="row.item.status.id === status.id">
                            <i class="fa fa-check" style="padding-right:5px"></i>{{status.name}}
                          </span>
                                <span v-else style="padding-left:21px">{{status.name}}</span>
                            </b-dropdown-item>
                        </b-dropdown>
                    </template>
                </b-table>
                <div class="justify-content-center row-margin-tweak row">
                    <b-pagination v-if="!isBusy" :size="template_size" :total-rows="count" :per-page="perPage" limit="5"
                                  v-model="currentPage"/>
                    <div v-else>...</div>
                </div>
            </div>
            <div class="card-footer text-muted">

            </div>
        </div>
    </div>
  </b-modal>
  <loading v-else></loading>
</template>

<script type="text/babel">
    import Loading from '../layout/Loading'
    import apiEquipment from '../../api/equipment'
    import apiTeams from '../../api/teams'
    import apiStatuses from '../../api/statuses'

    import ErrorHandler from '../../mixins/error-handler'
    import _ from 'lodash'

    export default {
        mixins: [ErrorHandler],
        name: 'Detail',
        components: {Loading},
        data() {
            return {
                isLoaded: false,
                showModal: true,
                projectId: null,
                user: null,
                statusId: null,
                equipments: [],
                header_text: '',
                fields: {
                    category_name: {
                        label: 'Category',
                        'class': 'text-center field-cat',
                        variant: 'green'
                    },
                    make_model: {
                        label: 'Make/Model',
                        sortable: true,
                        'class': 'text-center field-mod'
                    },
                    serial: {
                        label: 'Equipment #',
                        sortable: true,
                        'class': 'text-center field-serial'
                    },
                    team: {
                        label: 'Crew/Team',
                        sortable: true,
                        'class': 'text-center field-team'
                    },
                    location: {
                        label: 'Location',
                        sortable: true,
                        'class': 'text-center field-location'
                    },
                    status: {
                        label: 'Status',
                        sortable: true,
                        'class': 'text-center field-stat'
                    }
                },
                isBusy: false,
                currentPage: 1,
                perPage: 10,
                count: 0,
                sortBy: '',
                sortDesc: false,
                filter: '',
                fiter_debouncer: '',
                statuses: [],
                teams: [{
                    name: '------'
                }],
                teamId: null
            }
        },
        created() {
            this.projectId = parseInt(this.$route.params.project_id)
            this.user = this.$store.state.User.user
            this.statusId = 1
            if (this.user.role.id === 3) {
                this.teamId = this.user.teams[0].id
            }
            this.$nextTick(() => {
                this.initData()
            })
            this.$on('reloadData', () => {
                this.initData()
                this.$refs.DetailTable.refresh()
            })
        },
        watch: {
            filter: function (val) {
                this.debouncer()
            },
            showModal: function () {
                if (!this.showModal) {
                    this.$router.push({
                        name: 'Form Customer Responsibility',
                        params: {
                            project_id: this.projectId,
                            form_id: 6
                        }
                    })
                }
            }
        },
        methods: {
            initData() {
                const apis = [
                    apiStatuses.index(),
                    apiTeams.index()
                ]
                return Promise.all(apis)
                    .then(response => {
                        this.statuses = response[0].data.data
                        this.teams = [{
                            name: '------'
                        }]
                        this.teams = this.teams.concat(response[1].data.data)
                        this.isLoaded = true
                        return response
                    })
            },
            getEquipment(ctx) {
                let data = {
                    category_id: this.$route.params.category_id || '',
                    model_id: this.$route.params.model_id || '',
                    status_id: this.statusId,
                    team_id: this.teamId,
                    page: ctx.currentPage,
                    sort_by: ctx.sortBy || '',
                    sort_type: (ctx.sortDesc ? 'desc' : 'asc'),
                    per_page: ctx.perPage,
                    filter: ctx.filter,
                    id_from: this.$route.query.id_from || ''
                }
                return apiEquipment.index(data)
                    .then(response => {
                        let items = response.data.data
                        items = items.map(item => {
                            item.model = item.model || {name: ''}
                            item.model.category = item.model.category || {name: ''}
                            item.status = item.status || {name: ''}
                            item.team = item.team || {name: ''}
                            let number = item.serial.replace(item.model.category.prefix + ' ', '')
                            item.serial = {
                                original: item.serial,
                                prefix: item.model.category.prefix,
                                number: number,
                                validate: true
                            }
                            return item
                        })
                        this.count = response.data.total
                        this.header_text = (response.data.data.length) ? response.data.data[0].model.category.name : ''
                        if (this.$route.params.model_id && response.data.data.length) {
                            this.header_text += ' / ' + response.data.data[0].model.name
                            this.fields.make_model.sortable = false
                            this.fields.make_model.variant = 'green'
                            if (this.$route.params.status_id) {
                                this.header_text += ' / ' + response.data.data[0].status.name
                                this.fields.status.sortable = false
                                this.fields.status.variant = 'green'
                            }
                        }
                        this.equipments = items || []
                        return (this.equipments)
                    })
            },
            debouncer: _.debounce(function () {
                this.fiter_debouncer = this.filter
            }, 500),
            changeStatus(equipment, statusId) {
                let data = {
                    id: equipment.id,
                    status_id: statusId,
                    company_id: equipment.company_id
                }
                apiEquipment.patch(equipment.id, data)
                    .then(response => {
                        this.initData()
                        this.$refs.DetailTable.refresh()
                    })
                    .catch(this.handleErrorResponse)
            },
            validateSerialNumber: _.debounce(function (equipment) {
                if (!equipment.serial.number) {
                    equipment.serial.validate = false
                    return false
                }
                var pad = '0000000000'
                equipment.serial.number = equipment.serial.number.replace(new RegExp('^[0]+'), '')
                equipment.serial.number = equipment.serial.number.slice(0, pad.length)
                equipment.serial.number = pad.substring(0, pad.length - equipment.serial.number.length) + equipment.serial.number
                if (equipment.serial.original === equipment.serial.prefix + ' ' + equipment.serial.number) {
                    equipment.serial.validate = true
                    return true
                }
                let serial = equipment.serial.number
                return apiEquipment.valdiateSerial(serial, equipment.model.category_id)
                    .then(response => {
                        if (response.data.message === 'nonexistence') {
                            equipment.serial.validate = true
                            return true
                        }
                        equipment.serial.validate = false
                        return false
                    }).catch(err => {
                        if (err) {
                            equipment.serial.validate = false
                            return false
                        }
                    })
            }, 500)
        }
    }
</script>

<style>
.modal-content {
    width: 1000px;
    margin-left: -240px;
}
</style>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    .equipment-detail {
        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: .25rem;
        }
        .field-cat {
            width: 16%;
        }
        .field-mod {
            width: 16%;
        }
        .field-serial {
            width: 16%;
        }
        .field-team {
            width: 12%;
        }
        .field-location {
            width: 16%;
        }
        .field-status {
            width: 12%;
        }
        .field-act {
            width: 12%;
        }
        .table-green {
            background-color: rgba(0, 0, 0, 0.05) !important;
            color: inherit !important;
        }
        .serial-label {
            font-size: 1rem;
            padding: .1rem .5rem;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }
        .change-serial {
            cursor: pointer;
        }
    }
</style>