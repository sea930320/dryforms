<template>

    <b-modal id="removeProject" :title="modalName" class="text-left" @ok="remove()" v-model="show"
             :ok-title="'Confirm'" :ok-variant="'danger'">
        <h5>Are you sure?</h5>
    </b-modal>

</template>

<script type="text/babel">
    import apiProjects from '../../../api/projects'
    
    export default {
        name: 'remove-project-modal',
        created() {
            this.$parent.$on('openRemoveModal', (payload) => {
                this.id = payload.id
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                id: null
            }
        },
        computed: {
            modalName() {
                return 'Delete Project Confirmation'
            }
        },
        methods: {
            remove() {
                if (this.id) {
                    apiProjects.delete(this.id)
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
