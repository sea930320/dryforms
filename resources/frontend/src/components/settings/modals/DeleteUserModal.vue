<template>
    <b-modal id="delete-user-modal" :title="modalName" class="text-left" @ok="destroy()" v-model="show"
             :ok-title="'Confirm'" :ok-variant="'danger'">
        <h5>Are you sure?</h5>
    </b-modal>

</template>

<script type="text/babel">
    import apiUsers from '../../../api/users'
    import ErrorHandler from '../../../mixins/error-handler'

    export default {
        mixins: [ErrorHandler],
        name: 'delete-user-modal',
        created() {
            this.$parent.$on('openDeleteModal', (payload) => {
                this.user.id = payload.id
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                user: {
                    id: null
                }
            }
        },
        computed: {
            modalName() {
                return 'Delete User Confirmation'
            }
        },
        methods: {
            destroy() {
                if (this.user.id) {
                    apiUsers.delete(this.user.id)
                        .then(response => {
                            this.$parent.$emit('reloadData')
                        })
                        .catch(this.handleErrorResponse)
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>