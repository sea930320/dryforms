<template>

    <b-modal id="createModel" :title="modalName" class="text-left" @ok="destroy()" v-model="show"
             :ok-title="'Confirm'" :ok-variant="'danger'">
        <h5>Are you sure?</h5>
    </b-modal>

</template>

<script type="text/babel">
    import apiModels from '../../../../api/models'

    export default {
        name: 'delete-model-modal',
        created() {
            this.$parent.$on('openDeleteModal', (payload) => {
                this.model.id = payload.id
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                model: {
                    id: null
                }
            }
        },
        computed: {
            modalName() {
                return 'Delete Model Confirmation'
            }
        },
        methods: {
            destroy() {
                if (this.model.id) {
                    apiModels.delete(this.model.id)
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