<template>

    <b-modal id="createTeam" title="Create new team" class="text-left" @ok="store()">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" aria-describedby="emailHelp"
                   placeholder="Enter team name" v-model="team.name">
        </div>
        <div class="form-group">
            <label>Description:</label>
            <input type="text" class="form-control" aria-describedby="emailHelp"
                   placeholder="Enter short description" v-model="team.description">
        </div>
    </b-modal>

</template>

<script type="text/babel">
    import apiTeams from '../../../api/teams'

    export default {
        name: 'create-team-modal',
        data() {
            return {
                team: {
                    name: null,
                    description: null
                }
            }
        },
        methods: {
            store() {
                apiTeams.store(this.team)
                    .then(response => {
                        this.$parent.$emit('reloadData')
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