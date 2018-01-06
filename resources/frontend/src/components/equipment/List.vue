<template>
    <div>
        <div v-if="isLoaded" class="card text-center">
            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
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
                            <td>{{ model.category ? model.category.name : 'n/a' }}</td>
                            <td>{{ model.name }}</td>
                            <td>{{ model.total }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-sm table-bordered table-striped table-hover no-margin text-center"
                    v-for="category in equipment">
                    <thead>
                        <tr class="table-active">
                            <th colspan="6">{{ category.name }}</th>
                        </tr>
                        <tr>
                            <th colspan="6"></th>
                        </tr>
                        <tr>
                            <th>No.</th>
                            <th>Make/Model</th>
                            <th>Equipment #</th>
                            <th>Crew/Team</th>
                            <th>Location</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody v-if="category.equipments.length === 0">
                        <tr><td colspan="6">No equipment available</td></tr>
                    </tbody>
                    <tbody v-if="category.equipments.length > 0" v-for="(item, index) in category.equipments">
                        <tr>
                            <td>{{ ++index }}</td>
                            <td>{{ item.model ? item.model.name : 'n/a' }}</td>
                            <td>{{ item.serial }}</td>
                            <td>{{ item.team ? item.team.name : 'n/a' }}</td>
                            <td>{{ item.location }}</td>
                            <td>{{ item.status.name }}</td>
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
    import Loading from '../layout/Loading'
    import apiModels from '../../api/equipment-models'
    import apiEquipment from '../../api/equipment'

    export default {
        name: 'Settings',
        components: { Loading },
        data() {
            return {
                isLoaded: false,
                models: [],
                equipment: []
            }
        },
        created() {
            this.$nextTick(() => {
                this.initData()
            })
        },
        methods: {
            initData() {
                let data = [
                    apiModels.index(),
                    apiEquipment.index()
                ]

                return Promise.all(data)
                    .then(response => {
                        this.models = response[0].data.data
                        this.equipment = response[1].data.data
                        this.isLoaded = true

                        return response
                    })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
