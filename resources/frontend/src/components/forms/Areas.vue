<template>
    <b-modal id="selectForm" :title="$route.meta.title" v-model="showModal" size="lg">
        <div v-if="isLoaded">
            <b-row align-h="around">
                <b-col cols="4" class="text-center">
                    <h6>Selected affected areas</h6>
                    <div class="wrapper">
                        <b-list-group class="text-left">
                            <b-list-group-item v-for="(item, index) in projectAreas" :key="index" :active="!item.selected" @click="deselectArea(index)">{{ item.title }}
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
                            <b-list-group-item v-for="(item, index) in standardAreas" :key="index" :active="item.selected"  @click="selectArea(index)">{{ item.title }}
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
        <div slot="modal-footer" class="w-100">
            <b-btn  class="float-right" variant="secondary" @click="showModal=false">
                Close
            </b-btn>
            <b-btn class="float-right mr-2" variant="primary" @click="saveArea">
                Ok
            </b-btn>
       </div>
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
                    selected: false,
                    area_id: -1
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
                apiProjectAreas.index({
                    project_id: this.project_id
                }).then(res => {
                    let projectAreas = res.data.project_areas
                    this.standardAreas = res.data.standard_areas
                    projectAreas.forEach(projectArea => {
                        projectArea.title = projectArea.standard_area.title
                        projectArea.selected = true
                    })
                    this.projectAreas = projectAreas
                    this.standardAreas.forEach(standardArea => {
                        standardArea.area_id = standardArea.id
                    })
                    this.isLoaded = true
                }).catch(this.handleErrorResponse)
            },
            saveArea: function() {
                apiProjectAreas.store({
                    project_id: this.project_id,
                    standard_areas: this.standardAreas,
                    project_areas: this.projectAreas
                }).then(res => {
                    this.showModal = false
                }).catch(this.handleErrorResponse)
            },
            selectArea: function (index) {
                let selected = this.standardAreas[index].selected ? !this.standardAreas[index].selected : true
                this.$set(this.standardAreas[index], 'selected', selected)
            },
            addArea: function () {
                this.projectAreas.push(...this._.filter(this.standardAreas, {selected: true}))
                this._.remove(this.standardAreas, {selected: true})
            },
            deselectArea: function (index) {
                let selected = this.projectAreas[index].selected ? !this.projectAreas[index].selected : true
                this.$set(this.projectAreas[index], 'selected', selected)
            },
            removeArea: function () {
                this.standardAreas.push(...this._.filter(this.projectAreas, {selected: false}))
                this._.remove(this.projectAreas, {selected: false})
            },
            addNewArea: function() {
                this.$validator.validateAll()
                if (this.errors.any()) {
                    return
                }
                let newArea = Object.assign({}, this.newArea)
                this.newArea.title = ''
                this.standardAreas.push(newArea)
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