<template>
    <div class="card">
        <div class="card-body text-center">
            <form-header></form-header>
            <h4 class="mb-2">{{ $route.meta.title }}</h4>
            <div class="dropdown-divider"></div>
            <form-banner class="mt-2"></form-banner>
            <div class="dropdown-divider"></div>
            <statement></statement>
        </div>
        <div v-if="isLoaded" class="text-center">
            <div class="card-body text-left pt-3 pb-3">
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
                    </template>
                    <template slot="actions" slot-scope="row">
                        <button class="btn btn-xs btn-info" @click='changeStatus(row.item)'>
                            <i class="fa fa-undo"></i> Pick up
                        </button>
                    </template>
                </b-table>
                <div class="justify-content-center row-margin-tweak row">
                    <b-pagination v-if="!isBusy" :size="template_size" :total-rows="count" :per-page="perPage" limit="5"
                                  v-model="currentPage"/>
                    <div v-else>...</div>
                </div>
            </div>
            <notes class="mt-3"></notes>
            <footer-text class="mt-3"></footer-text>
            <signature class="mt-3"></signature>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import {mapActions} from 'vuex'
    import Loading from '../layout/Loading'
    import apiEquipment from '../../api/equipment'
    import apiTeams from '../../api/teams'
    import apiStatuses from '../../api/statuses'

    import FormHeader from './FormHeader'
    import FormBanner from './FormBanner'
    import Notes from './Notes'
    import FooterText from './FooterText'
    import Signature from './Signature'
    import Statement from './Statement'
    import _ from 'lodash'
    export default {
        components: {FormHeader, FormBanner, Statement, Notes, FooterText, Signature, Loading},
        data() {
            return {
                isLoaded: false,
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
                    },
                    actions: {
                        label: 'Action',
                        sortable: false,
                        'class': 'text-center'
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
            this.fetchUser()
            this.user = this.$store.state.User.user
            this.statusId = 3
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
            }
        },
        methods: {
            ...mapActions([
                'fetchUser'
            ]),
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
            changeStatus(equipment) {
                let data = {
                    id: equipment.id,
                    status_id: 1,
                    company_id: equipment.company_id
                }
                apiEquipment.patch(equipment.id, data)
                    .then(response => {
                        this.initData()
                        this.$refs.DetailTable.refresh()
                    })
                    .catch(this.handleErrorResponse)
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    table {
        width: 100%;
    }
</style>