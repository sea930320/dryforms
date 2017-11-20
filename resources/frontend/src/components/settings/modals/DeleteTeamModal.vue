<template>

    <b-modal id="createTeam" :title="modalName" class="text-left" @ok="destroy()" v-model="show"
             :ok-title="'Confirm'" :ok-variant="'danger'">
        <h5>Are you sure?</h5>
    </b-modal>

</template>

<script type="text/babel">
    import apiTeams from '../../../api/teams'

    export default {
        name: 'delete-team-modal',
        created() {
            this.$parent.$on('openDeleteModal', (payload) => {
                this.team.id = payload.id
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                team: {
                    id: null
                }
            }
        },
        computed: {
            modalName() {
                return 'Delete Team Confirmation'
            }
        },
        methods: {
            destroy() {
                if (this.team.id) {
                    apiTeams.delete(this.team.id)
                        .then(response => {
                            this.$parent.$emit('reloadData')
                        })
                        .catch(error => {
                            console.log(error.data)
                        })
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>