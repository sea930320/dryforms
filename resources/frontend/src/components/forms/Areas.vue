<template>
    <b-modal id="selectForm" :title="$route.meta.title" v-model="showModal" size="lg" @ok="saveArea">
        <div v-if="isLoaded">
            <b-row align-h="around">
                <b-col cols="4" class="text-center">
                    <h6>Selected affected areas</h6>
                    <div class="wrapper">
                        <b-list-group class="text-left">
                            <b-list-group-item v-for="item in projectAreas" :key="item.id" :active="!item.selected" @click="deselectArea(item.id)">{{ item.title }}
                            </b-list-group-item>
                        </b-list-group>
                    </div>
                    <div class="text-right mt-2">
                        Romove
                        <button @click="removeArea()"><i class="fa fa-arrow-right"></i></button>
                    </div>
                </b-col>
                <b-col cols="4" class="text-center">
                    <h6>Choose affected areas</h6>
                    <div class="wrapper">
                        <b-list-group class="text-left">
                            <b-list-group-item v-for="item in standardAreas" :key="item.id" :active="item.selected"  @click="selectArea(item.id)">{{ item.title }}
                            </b-list-group-item>
                        </b-list-group>
                    </div>
                    <div class="text-left mt-2">
                        <button @click="addArea()"><i class="fa fa-arrow-left"></i></button>
                        Add
                    </div>
                </b-col>
            </b-row>
            <b-row align-h="center">
                <b-col cols="4" class="text-center">
                    <h6>Add area to list</h6>
                    <b-input-group :size="template_size">
                        <input type="text" class="form-control form-control-sm" name="newArea" placeholder="Input Area" v-model="newArea.title" :class="{'is-invalid': errors.has('newArea')}" v-validate data-vv-rules="required">
                        <b-input-group-append>
                            <b-btn :size="template_size" variant="primary" @click="addNewArea()">
                                <i class="fa fa-plus"></i>
                            </b-btn>
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
            </b-row>
        </div>
        <loading v-else></loading>
    </b-modal>
</template>

<script type="text/babel">
    import Loading from '../layout/Loading'
    import apiProjectAreas from '../../api/project_areas'
    import ErrorHandler from '../../mixins/error-handler'

    export default {
        mixins: [ErrorHandler],
        components: {
            Loading
        },
        data() {
            return {
                showModal: true,
                projectAreas: [],
                standardAreas: [],
                project_id: null,
                isLoaded: false,
                newArea: {
                    title: '',
                    project_id: ''
                }
            }
        },
        created() {
            this.init()
        },
        watch: {
            showModal: function () {
                if (this.showModal) {
                    this.init()
                }
                if (!this.showModal) this.$router.go(-1)
            }
        },
        methods: {
            init: function() {
                this.project_id = this.$route.params.project_id
                this.newArea.project_id = this.project_id
                apiProjectAreas.index({
                    project_id: this.project_id
                }).then(res => {
                    this.projectAreas = res.data.project_areas
                    this.standardAreas = res.data.standard_areas
                    this.projectAreas.forEach(projectArea => {
                        projectArea.title = projectArea.standard_area.title
                        projectArea.selected = true
                    })
                    this.standardAreas.forEach(standardArea => {
                        standardArea.area_id = standardArea.id
                    })
                    this.isLoaded = true
                }).catch(this.handleErrorResponse)
            },
            saveArea: function() {
                apiProjectAreas.store({
                    project_id: this.project_id,
                    project_areas: this.projectAreas
                }).then(res => {
                    this.showModal = false
                }).catch(this.handleErrorResponse)
            },
            selectArea: function (index) {
                var arrIndex = this._.findIndex(this.standardAreas, {id: index})
                let selected = this.standardAreas[arrIndex].selected ? !this.standardAreas[arrIndex].selected : true
                this.$set(this.standardAreas[arrIndex], 'selected', selected)
            },
            addArea: function () {
                this.projectAreas.push(...this._.filter(this.standardAreas, {selected: true}))
                this._.remove(this.standardAreas, {selected: true})
            },
            deselectArea: function (index) {
                var arrIndex = this._.findIndex(this.projectAreas, {id: index})
                let selected = this.projectAreas[arrIndex].selected ? !this.projectAreas[arrIndex].selected : true
                this.$set(this.projectAreas[arrIndex], 'selected', selected)
            },
            removeArea: function () {
                this.standardAreas.push(...this._.filter(this.projectAreas, {selected: false}))
                this._.remove(this.projectAreas, {selected: false})
            },
            addNewArea: function() {
                // this.$validator.validateAll()
                // if (this.errors.any()) {
                //     return
                // }
                // this.standardAreas.push(this.newArea)
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .wrapper {
        min-height: 400px;
        border: 1px solid black;
    }

    .list-group-item {
        padding: 5px;
        border: 0;
        cursor: pointer;
    }
</style>