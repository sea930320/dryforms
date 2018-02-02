<template>
    <div class="settings-teams">
        <div class="card text-center" v-if="isLoaded">
            <create-team-modal></create-team-modal>
            <delete-team-modal></delete-team-modal>

            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
                <button class="btn pull-right btn-create" @click="openCreateModal()"><i class="fa fa-plus"></i></button>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-table ref="teamTable" :busy.sync="isBusy" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :items="getTeam" small striped hover foot-clone :fields="fields" :current-page="currentPage" :per-page="perPage" head-variant="">
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
            </div>
            <div class="card-footer text-muted">

            </div>
        </div>
        <loading v-else></loading>
    </div>    
</template>

<script type="text/babel">
    import Loading from '../layout/Loading'
    import apiTeams from '../../api/teams'
    import CreateTeamModal from './modals/CreateTeamModal'
    import DeleteTeamModal from './modals/DeleteTeamModal'

    export default {
        name: 'Teams',
        data() {
            return {
                isLoaded: false,
                teams: [],
                modal: null,
                fields: {
                  name: {
                    label: 'Name',
                    sortable: true,
                    'class': 'text-center field-name'
                  },
                  description: {
                    label: 'Description',
                    sortable: false,
                    'class': 'text-center field-desc'
                  },
                  action: {
                    label: 'Actions',
                    sortable: false,
                    'class': 'text-center field-act'
                  }
                },
                isBusy: false,
                currentPage: 1,
                perPage: 10,
                count: 0,
                sortBy: '',
                sortDesc: false
            }
        },
        components: {CreateTeamModal, DeleteTeamModal, Loading},
        created() {
            this.$nextTick(() => {
                this.initData()
            })
            this.$on('reloadData', () => {
                this.initData()
                this.$refs.teamTable.refresh()
            })
        },
        methods: {
            initData() {
                return apiTeams.index({page: 1})
                    .then(response => {
                        this.count = response.data.total
                        this.isLoaded = true
                        return response
                    })
            },
            getTeam(ctx) {
                let data = {
                  page: ctx.currentPage,
                  per_page: ctx.perPage
                }
                if (ctx.sortBy) {
                    data.sort_by = ctx.sortBy
                    data.sort_type = ctx.sortDesc ? 'desc' : 'asc'
                }
                return apiTeams.index(data)
                    .then(response => {
                        this.teams = response.data.data || []
                        this.count = response.data.total
                        return this.teams
                    })
            },
            openCreateModal() {
                this.$emit('openCreateModal')
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
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    .settings-teams {
        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: .25rem;
        }
        .field-name {
            width: 25%;
        }
        .field-desc {
            width: 50%;
        }
        .field-act {
            width: 25%;
        }
        .card-header {
            position: relative;
            .btn-create {
              position: absolute;
              top: 0px;
              bottom: 0px;
              right: 0px;
              font-size: 15px;
            }
        }
    }
</style>