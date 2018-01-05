<template>
    <b-modal id="addEquipModal" :title="$route.meta.title" class="text-left" v-model="show" size="lg">
        <b-row>
            <div class="form-group col-md-6">
                <label>Description</label>
                <select class="form-control" v-model="data.category_id">
                    <option :value="null">-- Please select --</option>
                    <option v-for="item in categories" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Add New Description</label>
                <input type="text" class="form-control" v-model="newCategory" :disabled="data.category_id">
            </div>
        </b-row>
        <b-row>
            <div class="form-group col-md-6">
                <label>Make/Model</label>
                <select class="form-control" v-model="data.model_id">
                    <option :value="null">-- Please select --</option>
                    <option v-for="item in models" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Add New Make/Model</label>
                <input type="text" class="form-control" v-model="newModel" :disabled="data.model_id">
            </div>
        </b-row>
        <b-row>
            <div class="form-group col-md-6">
                <label>Equipment #</label>
                <input type="number" class="form-control" v-model="data.quantity">
            </div>
            <div class="form-group col-md-6">
                <label>Equipment # through</label>
                <input type="text" class="form-control">
            </div>
        </b-row>
        <b-row>
            <div class="form-group col-md-6">
                <label>Crew/Team</label>
                <select class="form-control" v-model="data.team_id">
                    <option :value="null">-- Please select --</option>
                    <option v-for="item in teams" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Statuses</label>
                <select class="form-control" v-model="data.status_id">
                    <option :value="null">-- Please select --</option>
                    <option v-for="item in statuses" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
        </b-row>
        <div slot="modal-footer" class="w-100">
            <b-btn class="float-left" variant="primary" @click="addEquip()">Add</b-btn>
            <b-btn class="float-right" @click="enterEquip()">Enter</b-btn>
        </div>
    </b-modal>
</template>

<script type="text/babel">
    import apiCategories from '../../../api/categories'
    import apiModels from '../../../api/models'
    import apiTeams from '../../../api/teams'
    import apiStatuses from '../../../api/statuses'
    import apiEquipment from '../../../api/equipment'
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'add-equip-modal',
        data () {
            return {
                show: true,
                categories: [],
                models: [],
                data: {
                    'model_id': null,
                    'category_id': null,
                    'team_id': null,
                    'status_id': null
                },
                newModel: '',
                newCategory: '',
                statuses: [],
                teams: []
            }
        },
        mounted() {
            this.fetchUser()
        },
        created() {
            this.$nextTick(() => {
                this.getList()
            })
            this.$on('reloadData', () => {
                this.getList()
            })
        },
        computed: {
            // mix the getters into computed with object spread operator
            ...mapGetters({
                company_id: 'CompanyId',
                user_id: 'UserId'
            })
        },
        watch: {
            show: function () {
                if (this.show === false) this.$router.go(-1)
            },
            data: {
                handler(val) {
                    if (val.category_id !== null) {
                        this.newCategory = ''
                    }
                    if (val.model_id !== null) {
                        this.newModel = ''
                    }
                },
                deep: true
            }
        },
        methods: {
            ...mapActions([
                'getCompany',
                'fetchUser'
            ]),
            getList() {
                apiModels.index()
                    .then(response => {
                        this.models = response.data.data
                    })
                apiTeams.index()
                    .then(response => {
                        this.teams = response.data.data
                    })
                apiCategories.index()
                    .then(response => {
                        this.categories = response.data.data
                    })
                apiStatuses.index()
                    .then(response => {
                        this.statuses = response.data.data
                    })
            },
            addEquip () {
                if (this.newCategory) {
                    let self = this
                    apiCategories.store({
                        name: this.newCategory,
                        prefix: this.newCategory,
                        company_id: this.company_id
                    }).then(response => {
                        self.data.category_id = response.data.category.id
                        if (self.newModel) {
                            apiModels.store({
                                name: self.newModel,
                                category_id: self.data.category_id,
                                company_id: self.company_id
                            }).then(response => {
                                console.log(response.data)
                            })
                        }
                    })
                }
                this.data.company_id = this.company_id
                apiEquipment.store(this.data).then(response => {
                    console.log(response)
                })

                this.$router.go(-1)
            },
            enterEquip () {
                this.$router.go(-1)
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
