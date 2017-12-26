<template>

    <b-modal id="addEquip" :title="$route.meta.title" class="text-left" v-model="show" size="lg">
        <b-row>
            <div class="form-group col-md-6">
                <label>Category</label>
                <select class="form-control">
                    <option :value="null">-- Please select --</option>
                    <option v-for="item in categories" :value="item.name">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Add New Description</label>
                <input type="text" class="form-control">
            </div>
        </b-row>
        <b-row>
            <div class="form-group col-md-6">
                <label>Make/Model</label>
                <select class="form-control">
                    <option :value="null">-- Please select --</option>
                    <option v-for="item in models" :value="item.name">{{ item.name }}</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Add New Make/Model</label>
                <input type="text" class="form-control">
            </div>
        </b-row>
        <b-row>
            <div class="form-group col-md-6">
                <label>Equipment #</label>
                <input type="text" class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label>Equipment # through</label>
                <input type="text" class="form-control">
            </div>
        </b-row>
        <b-row>
            <div class="form-group col-md-6">
                <label>Crew/Team</label>
                <select class="form-control">
                    <option :value="null">-- Please select --</option>
                    <option v-for="item in teams" :value="item.name">{{ item.name }}</option>
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
    import apiCategories from 'src/api/categories'
    import apiTeams from 'src/api/teams'

    export default {
        name: 'add-equip-modal',
        data() {
            return {
                show: true,
                categories: [],
                models: [],
                teams: []
            }
        },
        created() {
            this.$nextTick(() => {
                this.initDependencies()
            })
        },
        watch: {
            show: () => {
                if (this.show === false) this.$router.push('/equipment')
            }
        },
        methods: {
            addEquip() {
                this.$router.push('/equipment')
            },
            enterEquip() {
                this.$router.push('/equipment')
            },
            initDependencies() {
                const data = [
                    apiCategories.get(),
                    apiTeams.get()
                ]

                return Promise.all(data)
                    .then(response => {
                        this.categories = response[0].data
                        this.models = response[1].data

                        return response
                    })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>