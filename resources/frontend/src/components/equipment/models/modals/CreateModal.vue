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
                <option>-- Please select --</option>
                <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <input type="text" class="form-control" aria-describedby="emailHelp"
                   placeholder="Enter short description" v-model="model.description">
        </div>
    </b-modal>

</template>

<script type="text/babel">
    import apiModels from '../../../../api/models'
    import apiCategories from '../../../../api/categories'

    export default {
        name: 'create-model-modal',
        created() {
            this.$parent.$on('openCreateModal', () => {
                this.model = {
                    id: null,
                    name: null,
                    category_id: null,
                    description: null
                }
                this.show = true
            })
            this.$parent.$on('openEditModal', (payload) => {
                this.model.id = payload.id
                this.initData()
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
                    category_id: null,
                    description: null
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
                const data = [
                    apiModels.show(this.model.id),
                    apiCategories.index()
                ]

                return Promise.all(data)
                    .then(response => {
                        self.model = response[0].data
                        self.categories = response[1].data.data
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