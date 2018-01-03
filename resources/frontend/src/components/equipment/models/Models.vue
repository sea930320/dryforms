<template>
    <div>
        <div class="card text-center" v-if="isLoaded">
            <create-modal></create-modal>
            <delete-modal></delete-modal>

            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>                
            </div>
            <div class="card-body text-left p-0">
                <button class="btn btn-xs btn-success pull-right m-2" @click="openCreateModal()"><i class="fa fa-plus"></i> Create</button>
                <table class="table table-sm table-bordered table-striped table-hover no-margin text-center">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="model in models">
                        <td>{{ model.name }}</td>
                        <td>{{ model.category.name }}</td>
                        <td>{{ model.description }}</td>
                        <td class="text-center">
                            <button class="btn btn-xs btn-default" @click="openEditModal(model.id)">
                                <i class="fa fa-pencil"></i> Edit
                            </button>
                            <button class="btn btn-xs btn-danger" @click="openDeleteModal(model.id)">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted">

            </div>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import Loading from '../../layout/Loading'
    import apiModels from '../../../api/models'
    import CreateModal from './modals/CreateModal'
    import DeleteModal from './modals/DeleteModal'

    export default {
        name: 'Models',
        data() {
            return {
                isLoaded: false,
                models: [],
                modal: null
            }
        },
        components: {CreateModal, DeleteModal, Loading},
        created() {
            this.$nextTick(() => {
                this.getList()
            })
            this.$on('reloadData', () => {
                this.getList()
            })
        },
        methods: {
            getList() {
                apiModels.index()
                    .then(response => {
                        this.models = response.data.data
                        this.isLoaded = true
                    })
            },
            openCreateModal() {
                this.$emit('openCreateModal')
            },
            openEditModal(id) {
                this.$emit('openEditModal', {
                    id: id
                })
            },
            openDeleteModal(id) {
                this.$emit('openDeleteModal', {
                    id: id
                })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>