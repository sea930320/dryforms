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
        <div class="form-group">
            <label>Description:</label>
            <input type="text" class="form-control" aria-describedby="emailHelp"
                   placeholder="Enter short description" v-model="category.description">
        </div>
    </b-modal>

</template>

<script type="text/babel">
    import apiCategories from '../../../../api/categories'

    export default {
        name: 'create-category-modal',
        created() {
            this.$parent.$on('openCreateModal', () => {
                this.category = {
                    id: null,
                    name: null,
                    prefix: null,
                    description: null
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
                    prefix: null,
                    description: null
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
                    apiCategories.store(this.category)
                        .then(response => {
                            this.$parent.$emit('reloadData')
                        })
                        .catch(error => {
                            console.log(error)
                        })
                } else {
                    apiCategories.patch(this.category.id, this.category)
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
                apiCategories.show(this.category.id)
                    .then(response => {
                        self.category = response.data
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