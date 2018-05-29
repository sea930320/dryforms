<template>
    <div class="card">
        <div v-if="isLoaded" class="card-body text-center">
            <form-header></form-header>
            <h4 class="mb-2">{{ $route.meta.title }}</h4>
            <div class="dropdown-divider"></div>
            <form-banner></form-banner>
            <div v-for="projectarea in projectAreas" :key="projectarea.id" >
                <mois-area :title="projectarea.title" :areaid="projectarea.id" class="mt-3"></mois-area>
            </div>
            <notes class="mt-3"></notes>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import FormHeader from './FormHeader'
    import FormBanner from './FormBanner'
    import MoisArea from './MoisArea'
    import Notes from './Notes'
    import apiProjectAreas from '../../api/project_areas'
    import Loading from '../layout/Loading'
    import DatePicker from 'vue2-datepicker'
    export default {
        components: {FormHeader, FormBanner, MoisArea, Notes, Loading, DatePicker},
        data() {
            return {
                projectAreas: [],
                standardAreas: [],
                project_id: null,
                structures: [],
                materials: [],
                isLoaded: false
            }
        },
        created() {
            this.init()
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
                    })
                    this.projectAreas = projectAreas
                    this.isLoaded = true
                }).catch(this.handleErrorResponse)
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .row-border {
        border: 1px solid black;
    }

    .bg-grey {
        background-color: #c3c3c3;
    }
</style>

