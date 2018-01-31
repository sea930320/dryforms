<template>
    <div class="settings-company">
        <div class="card text-center" v-if="isLoaded">
            <edit-modal :roles="roles" :teams="teams"></edit-modal>
            <delete-modal></delete-modal>
            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-table ref="UserTable" :busy.sync="isBusy" :items="getUsers" small striped hover foot-clone :fields="fields" :current-page="currentPage" :per-page="perPage" head-variant="">
                    <template slot="no" slot-scope="data">
                        {{data.index + 1}}
                    </template>
                    <template slot="type" slot-scope="row">
                        {{row.item.role.name}}
                    </template>
                    <template slot="team" slot-scope="row">
                        {{row.item.teams.length ? row.item.teams[0].name : "n/a"}}
                    </template>
                    <template slot="action" slot-scope="row">
                        <button class="btn btn-xs btn-default" @click="openEditModal(row.item.id)">
                            <i class="fa fa-pencil"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger" @click="openDeleteModal(row.item.id)">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </template>
                </b-table>
                <div class="justify-content-center row-margin-tweak row">
                  <b-pagination v-if="!isBusy" :size="template_size" :total-rows="count" :per-page="perPage" limit="5" v-model="currentPage" />
                  <div v-else>...</div>
                </div>
                <div class="row mr-0 ml-0 justify-content-start mt-4">
                    <form class="col-md-6 row mr-2 ml-2" data-vv-scope="create-user" @submit.prevent="validateBeforeSubmit">
                        <div class="col-md-12 text-center">
                            <p>Create new account for your company employee</p>
                        </div>
                        <div class="form-group col-md-6">
                            <label>First Name:</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Input first name" v-model="newUser.first_name" name="new_firstName" :class="{'is-invalid': errors.has('new_firstName')}" v-validate data-vv-rules="required" :disabled="pending">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Last Name:</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Input last name" v-model="newUser.last_name" name="new_lastName" :class="{'is-invalid': errors.has('new_lastName')}" v-validate data-vv-rules="required" :disabled="pending">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Email:</label>
                            <input type="text" class="form-control form-control-sm" placeholder="Input Email Address" v-model="newUser.email" name="new_email" :class="{'is-invalid': errors.has('new_email')}" v-validate data-vv-rules="required|email" :disabled="pending">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Type:</label>
                            <select class="form-control form-control-sm" v-model="newUser.role_id" name="new_role" :class="{'is-invalid': errors.has('new_role')}" v-validate data-vv-rules="required" :disabled="pending">
                                <option value="">-- Please select --</option>
                                <option v-for="item in roles" v-bind:key="item.value" :value="item.value">{{ item.text }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Team:</label>
                            <b-form-select v-model="newUser.team_id" :options="teams" :size="template_size" :disabled="pending">
                            </b-form-select>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <input type="submit" class="btn btn-sm btn-primary" value="Create" :disabled="pending">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import Loading from '../layout/Loading'
    import apiUsers from '../../api/users'
    import apiTeams from '../../api/teams'
    import apiRoles from '../../api/roles'

    import EditModal from './modals/EditUserModal'
    import DeleteModal from './modals/DeleteUserModal'
    import ErrorHandler from '../../mixins/error-handler'
    import { mapGetters, mapActions } from 'vuex'
    
    export default {
        name: 'Company',
        mixins: [ErrorHandler],
        components: {
            Loading, EditModal, DeleteModal
        },
        data() {
            return {
                users: [],
                pending: false,
                newUser: {
                    first_name: '',
                    last_name: '',
                    email: '',
                    role_id: '',
                    team_id: null
                },
                roles: [],
                teams: [],
                fields: {
                    no: {
                        label: 'No.',
                        sortable: false,
                        'class': 'text-center field-no'
                    },
                    first_name: {
                        label: 'First Name',
                        sortable: false,
                        'class': 'text-center field-first-name'
                    },
                    last_name: {
                        label: 'Last Name',
                        sortable: false,
                        'class': 'text-center field-last-name'
                    },
                    email: {
                        label: 'Email',
                        sortable: false,
                        'class': 'text-center field-email'
                    },
                    type: {
                        label: 'Type',
                        sortable: false,
                        'class': 'text-center field-type'
                    },
                    team: {
                        label: 'Team',
                        sortable: false,
                        'class': 'text-center field-team'
                    },
                    action: {
                        label: 'Actions',
                        sortable: false,
                        'class': 'text-center field-actions'
                    }
                },
                isBusy: false,
                currentPage: 1,
                perPage: 20,
                count: 0
            }
        },
        created() {
            this.$nextTick(() => {
                this.initData()
            })
            this.$on('reloadData', () => {
                this.$refs.UserTable.refresh()
            })
        },
        methods: {
            ...mapActions([
                'fetchUser'
            ]),
            initData() {
                this.fetchUser()
                const apis = [
                    apiUsers.index(),
                    apiTeams.index(),
                    apiRoles.index()
                ]
                return Promise.all(apis)
                    .then(response => {
                        this.count = response[0].data.total
                        let teams = response[1].data.data.map(item => {
                            item.value = item.id
                            item.text = item.name
                            return item
                        })
                        this.teams = [{
                            value: null,
                            text: '-- Please select --'
                        }]
                        this.teams = this.teams.concat(teams)

                        let roles = response[2].data.data.map(item => {
                            item.value = item.id
                            item.text = item.name
                            return item
                        })
                        this.roles = roles
                        return response
                    })
            },
            getUsers(ctx) {
                let data = {
                    page: ctx.currentPage,
                    per_page: ctx.perPage
                }
                return apiUsers.index(data)
                    .then(response => {
                        let items = response.data.data
                        this.count = response.data.total
                        this.users = items || []
                        return (this.users)
                    })
            },
            openEditModal(id) {
                this.$emit('openEditModal', {
                    id: id
                })
            },
            openDeleteModal(id) {
                this.$emit('openDeleteModal', {
                    id: id
                })
            },
            validateBeforeSubmit() {
                this.$validator.validateAll('create-user')
                if (this.errors.any()) {
                  return
                }
                this.createUser()
            },
            createUser() {
                this.pending = true
                this.newUser.company_id = this.companyId
                let self = this
                apiUsers.store(this.newUser)
                    .then(response => {
                        self.newUser = {
                            first_name: '',
                            last_name: '',
                            email: '',
                            role_id: '',
                            team_id: null
                        }
                        self.pending = false
                        self.$emit('reloadData')
                    })
                    .catch(err => {
                        self.handleErrorResponse(err)
                        self.pending = false
                    })
            }
        },
        computed: {
            ...mapGetters([
                'companyId'
            ]),
            isLoaded: function() {
                return this.count !== 0 && this.companyId
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    .field-no {
        width: 5%
    }
    .field-first-name {
        width: 10%
    }
    .field-last-name {
        width: 10%
    }
    .field-email {
        width: 25%
    }
    .field-type {
        width: 10%
    }
    .field-team {
        width: 20%
    }
    .field-actions {
        width: 20%
    }
</style>