<template>
    <div>
        <div class="card text-center" v-if="isLoaded">
            <create-team-modal></create-team-modal>
            <delete-team-modal></delete-team-modal>

            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
                <button class="btn btn-xs btn-success pull-right" @click="openCreateModal()"><i class="fa fa-plus"></i> Create</button>
            </div>
            <div class="card-body text-left p-0">
                <table class="table table-sm table-bordered table-striped table-hover no-margin text-center">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="team in teams">
                        <td>{{ team.name }}</td>
                        <td>{{ team.description }}</td>
                        <td class="text-center">
                            <button class="btn btn-xs btn-default" @click="openEditModal(team.id)">
                                <i class="fa fa-pencil"></i> Edit
                            </button>
                            <button class="btn btn-xs btn-danger" @click="openDeleteModal(team.id)">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
                modal: null
            }
        },
        components: {CreateTeamModal, DeleteTeamModal, Loading},
        created() {
            this.$nextTick(() => {
                this.getList()
            })
            this.$on('reloadData', () => {
                this.getList()
            })
        },
        methods: {
            getList() {
                apiTeams.index()
                    .then(response => {
                        this.teams = response.data.data
                        this.isLoaded = true
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
</style>