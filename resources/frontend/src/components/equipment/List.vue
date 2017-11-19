<template>
    <div class="card text-center">
        <div class="card-header">
            {{ $route.meta.title }}
        </div>
        <div class="card-body text-left p-0">
            <table class="table table-bordered table-striped table-hover no-margin">
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
                    <tr v-for="category in categories">
                        <td>{{ category.name }}</td>
                        <td></td>
                        <td></td>
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
    import apiCategories from '../../api/equipment-categories'

    export default {
        name: 'Settings',
        data() {
            return {
                categories: []
            }
        },
        created() {
            this.$nextTick(() => {
                this.getList()
            })
        },
        methods: {
            getList() {
                apiCategories.index()
                    .then(response => {
                        this.categories = response.data.data
                    })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>