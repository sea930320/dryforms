<template>
  <b-modal id="selectForm" title="Add days for this project" v-model="showModal" v-if="isLoaded">
    <div>
        <label>Pick Date: </label>
        <date-picker v-model="rangedate" lang="en" range :shortcuts="shortcuts"></date-picker>
    </div>
    <div v-for="area in projectAreas" :key="area.id">
      <b-form-checkbox v-model="selectedAreas[area.id]" value=1 unchecked-value=0>
        {{area.title}}
      </b-form-checkbox>
    </div>
    <div slot="modal-footer" class="w-100">
        <b-btn  class="float-right" variant="secondary" @click="showModal=false">
            Close
        </b-btn>
        <b-btn class="float-right mr-2" variant="primary" @click="save()">
            Ok
        </b-btn>
    </div>
  </b-modal>
  <loading v-else></loading>
</template>

<script type="text/babel">
    import Loading from '../layout/Loading'
    import apiProjectAreas from '../../api/project_areas'
    import apiProjectMoistureDays from '../../api/project_moisture_days'
    import ErrorHandler from '../../mixins/error-handler'
    import DatePicker from 'vue2-datepicker'
    export default {
        mixins: [ErrorHandler],
        components: {
            Loading,
            DatePicker
        },
        data () {
            return {
                showModal: true,
                projectAreas: [],
                selectedAreas: [],
                projectId: null,
                isLoaded: false,
                shortcuts: [
                    {
                        text: 'Today',
                        start: new Date(),
                        end: new Date()
                    }
                ],
                rangedate: null
            }
        },
        created() {
            this.init()
        },
        methods: {
            init: function() {
                this.projectId = parseInt(this.$route.params.project_id)
                apiProjectAreas.index({
                    project_id: this.projectId
                }).then(res => {
                    let projectAreas = res.data.project_areas
                    this.standardAreas = res.data.standard_areas
                    projectAreas.forEach(projectArea => {
                        projectArea.title = projectArea.standard_area.title
                    })
                    this.projectAreas = projectAreas
                    this.isLoaded = true
                }).catch(this.handleErrorResponse)
            },
            save () {
                apiProjectMoistureDays.store({
                    selectedAreas: this.selectedAreas,
                    rangedate: this.rangedate
                }).then(res => {
                    this.showModal = false
                }).catch(this.handleErrorResponse)
            }
        },
        watch: {
            showModal: function () {
                if (this.showModal) {
                    this.init()
                }
                if (!this.showModal) this.$router.go(-1)
            }
        }
    }
</script>