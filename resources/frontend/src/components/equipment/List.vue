<template>
    <div class="card text-center">
        <div class="card-header">
            {{ $route.meta.title }}
        </div>
        <div class="card-body text-left p-0">
            <table class="table table-sm table-bordered table-striped table-hover no-margin text-center">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Make/Model</th>
                        <th>Total</th>
                        <th>O.O.C</th>
                        <th>Loan</th>
                        <th>Set</th>
                        <th>Available</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="model in models">
                        <td>{{ model.category.name }}</td>
                        <td>{{ model.name }}</td>
                        <td>{{ model.total }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted">

        </div>
    </div>
</template>

<script type="text/babel">
    import apiModels from '../../api/equipment-models'

    export default {
        name: 'Settings',
        data() {
            return {
                models: []
            }
        },
        created() {
            this.$nextTick(() => {
                this.getList()
            })
        },
        methods: {
            getList() {
                apiModels.index()
                    .then(response => {
                        this.models = response.data.data
                    })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>