<template>
    <div class="card" style="min-height: 100vh;">
        <div class="card-body text-center">
            <form-header></form-header>
            <h4 class="mb-2">{{ $route.meta.title }}</h4>
            <div class="dropdown-divider"></div>
            <form-banner class="mt-2"></form-banner>
            <div class="dropdown-divider"></div>
            <create-dailylog-modal></create-dailylog-modal>
            <b-row>
                <b-col class="text-right">
                    <b-btn variant="outline-primary" @click="addLog()">
                        Add Log
                    </b-btn>
                </b-col>
            </b-row>
            <b-row v-for="dailyLog in dailyLogs" :key="dailyLog.updated_at">
                <b-col class="text-left">
                    <h6> {{ dailyLog.updated_at }} {{ userName }} </h6>
                    <b-form-textarea :rows="3" @input='updateNotes(dailyLog)' v-model='dailyLog.notes'></b-form-textarea>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script type="text/babel">
    import FormHeader from './FormHeader'
    import FormBanner from './FormBanner'
    import ErrorHandler from '../../mixins/error-handler'
    import apiProjectDailylogs from '../../api/project_dailylog'
    import CreateDailylogModal from './modals/AddDailyLog'
    import _ from 'lodash'

    export default {
        mixins: [ErrorHandler],
        name: 'dailylog',
        components: {FormHeader, FormBanner, CreateDailylogModal},
        data() {
            return {
                projectId: null,
                dailyLogs: [],
                userName: null
            }
        },
        created() {
            this.projectId = this.$route.params.project_id
            this.$nextTick(() => {
                this.init()
            })
            this.$on('reloadData', () => {
                this.init()
            })
        },
         methods: {
            init() {
                apiProjectDailylogs.index({
                    project_id: this.projectId
                }).then(res => {
                    this.dailyLogs = res.data.projectDailylogs
                    this.userName = res.data.userName
                }).catch(this.handleErrorResponse)
            },
            addLog() {
                this.$emit('openCreateDailyLogModal')
            },
            updateNotes: _.debounce(function(dailylog) {
                apiProjectDailylogs.patch(dailylog.id, dailylog)
                .then(res => {
                    dailylog.updated_at = res.data.projectDailylog.updated_at
                }).catch(this.handleErrorResponse)
            }, 500)
         }
    }
</script>