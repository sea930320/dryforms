<template>
    <div class="card text-center">
        <create-modal></create-modal>
        <delete-modal></delete-modal>

        <div class="card-header">
            {{ $route.meta.title }}
            <button class="btn btn-xs btn-success pull-right" @click="openCreateModal()"><i class="fa fa-plus"></i> Create</button>
        </div>
        <div class="card-body text-left p-0">
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
</template>

<script type="text/babel">
    import apiModels from '../../../api/models'
    import CreateModal from './modals/CreateModal'
    import DeleteModal from './modals/DeleteModal'

    export default {
        name: 'Models',
        data() {
            return {
                models: [],
                modal: null
            }
        },
        components: {CreateModal, DeleteModal},
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