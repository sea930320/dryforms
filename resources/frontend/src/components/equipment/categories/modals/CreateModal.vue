<template>

    <b-modal id="createCategory" :title="modalName" class="text-left" @ok="store()" v-model="show">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" aria-describedby="emailHelp"
                   placeholder="Enter category name" v-model="category.name">
        </div>
        <div class="form-group">
            <label>Prefix:</label>
            <input type="text" class="form-control" aria-describedby="emailHelp"
                   placeholder="Enter prefix" v-model="category.prefix">
        </div>
    </b-modal>

</template>

<script type="text/babel">
    import apiCategories from '../../../../api/categories'
    import ErrorHandler from '../../../../mixins/error-handler'

    export default {
        mixins: [ErrorHandler],
        name: 'create-category-modal',
        created() {
            this.$parent.$on('openCreateModal', () => {
                this.category = {
                    id: null,
                    name: null,
                    prefix: null
                }
                this.show = true
            })
            this.$parent.$on('openEditModal', (payload) => {
                this.category.id = payload.id
                this.initData()
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                category: {
                    id: null,
                    name: null,
                    prefix: null
                }
            }
        },
        computed: {
            modalName() {
                return this.category.id ? 'Edit Category' : 'Create Category'
            }
        },
        methods: {
            store() {
                if (!this.category.id) {
                    this.category.company_id = 2
                    apiCategories.store(this.category)
                        .then(response => {
                            this.$parent.$emit('reloadData')
                        })
                        .catch(this.handleErrorResponse)
                } else {
                    apiCategories.patch(this.category.id, this.category)
                        .then(response => {
                            this.$parent.$emit('reloadData')
                        })
                        .catch(this.handleErrorResponse)
                }
            },
            initData() {
                let self = this
                apiCategories.show(this.category.id)
                    .then(response => {
                        self.category = response.data
                    })
                    .catch(this.handleErrorResponse)
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
