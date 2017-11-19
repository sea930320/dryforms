<template>
    <div class="card text-center">
        <create-team-modal></create-team-modal>

        <div class="card-header">
            {{ $route.meta.title }}
            <b-btn v-b-modal.createTeam :class="'btn btn-sm btn-success pull-right'"><i class="fa fa-plus"></i> </b-btn>
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
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted">

        </div>
    </div>
</template>

<script type="text/babel">
    import apiTeams from '../../api/teams'
    import CreateTeamModal from './modals/CreateTeamModal'

    export default {
        name: 'Teams',
        data() {
            return {
                teams: [],
                modal: null
            }
        },
        components: {CreateTeamModal},
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
                    })
            },
            createTeamModal() {
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>