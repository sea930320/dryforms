<template>

    <b-modal id="createCategory" :title="modalName" class="text-left" @ok="destroy()" v-model="show"
             :ok-title="'Confirm'" :ok-variant="'danger'">
        <h5>Are you sure?</h5>
    </b-modal>

</template>

<script type="text/babel">
    import apiCategories from '../../../../api/categories'

    export default {
        name: 'delete-category-modal',
        created() {
            this.$parent.$on('openDeleteModal', (payload) => {
                this.category.id = payload.id
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                category: {
                    id: null
                }
            }
        },
        computed: {
            modalName() {
                return 'Delete Category Confirmation'
            }
        },
        methods: {
            destroy() {
                if (this.category.id) {
                    apiCategories.delete(this.category.id)
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