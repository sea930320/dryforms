<template>

    <b-modal id="createTeam" :title="modalName" class="text-left" @ok="store()" v-model="show">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" aria-describedby="emailHelp"
                   placeholder="Enter team name" v-model="team.name">
        </div>
    </b-modal>

</template>

<script type="text/babel">
    import apiTeams from '../../../api/teams'

    export default {
        name: 'create-team-modal',
        created() {
            this.$parent.$on('openCreateModal', () => {
                this.team = {
                    id: null,
                    name: null
                }
                this.show = true
            })
            this.$parent.$on('openEditModal', (payload) => {
                this.team.id = payload.id
                this.initData()
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                team: {
                    id: null,
                    name: null
                }
            }
        },
        computed: {
            modalName() {
                return this.team.id ? 'Edit team' : 'Create team'
            }
        },
        methods: {
            store() {
                if (!this.team.id) {
                    this.team.company_id = 2
                    apiTeams.store(this.team)
                        .then(response => {
                            this.$parent.$emit('reloadData')
                        })
                        .catch(error => {
                            console.log(error)
                        })
                } else {
                    apiTeams.patch(this.team.id, this.team)
                        .then(response => {
                            this.$parent.$emit('reloadData')
                        })
                        .catch(error => {
                            console.log(error)
                        })
                }
            },
            initData() {
                let self = this
                apiTeams.show(this.team.id)
                    .then(response => {
                        self.team = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>