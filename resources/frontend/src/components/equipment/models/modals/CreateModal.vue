<template>

    <b-modal id="createModel" :title="modalName" class="text-left" @ok="store()" v-model="show">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" aria-describedby="emailHelp"
                   placeholder="Enter model name" v-model="model.name">
        </div>
        <div class="form-group">
            <label>Category:</label>
            <select class="form-control" v-model="model.category_id">
                <option value="">-- Please select --</option>
                <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
            </select>
        </div>
    </b-modal>

</template>

<script type="text/babel">
    import apiModels from '../../../../api/models'
    import apiCategories from '../../../../api/categories'

    export default {
        name: 'create-model-modal',
        created() {
            this.initData()
            this.$parent.$on('openCreateModal', () => {
                this.model = {
                    id: null,
                    name: null,
                    category_id: ''
                }
                this.show = true
            })
            this.$parent.$on('openEditModal', (payload) => {
                let self = this
                this.model.id = payload.id
                apiModels.show(this.model.id)
                    .then(response => {
                        self.model = response.data
                    })
                    .catch(error => {
                        console.log(error.response)
                    })

                this.show = true
            })
        },
        data() {
            return {
                show: false,
                categories: [],
                model: {
                    id: null,
                    name: null,
                    category_id: null
                }
            }
        },
        computed: {
            modalName() {
                return this.model.id ? 'Edit Model' : 'Create Model'
            }
        },
        methods: {
            store() {
                if (!this.model.id) {
                    this.model.company_id = 2
                    apiModels.store(this.model)
                        .then(response => {
                            this.$parent.$emit('reloadData')
                        })
                        .catch(error => {
                            console.log(error)
                        })
                } else {
                    apiModels.patch(this.model.id, this.model)
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
                apiCategories.index()
                    .then(response => {
                        self.categories = response.data.data
                    })
                    .catch(error => {
                        console.log(error.response)
                    })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>