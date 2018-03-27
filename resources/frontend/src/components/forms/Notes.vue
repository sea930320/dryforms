<template>
    <b-row v-if="enabled">
        <b-col class="text-left">
            <h6>Additional notes:</h6>
            <b-form-textarea :rows="3" @input='updateNotes()' v-model='dailylog.notes'></b-form-textarea>
        </b-col>
    </b-row>
</template>

<script type="text/babel">
    import ErrorHandler from '../../mixins/error-handler'
    import apiProjectDailylogs from '../../api/project_dailylog'
    import _ from 'lodash'

    export default {
        mixins: [ErrorHandler],
        name: 'notes',
        data() {
            return {
                enabled: false,
                dailylog: {
                    id: null,
                    project_id: null,
                    form_id: null,
                    notes: '',
                    is_copied: 1
                }
            }
        },
        created() {
            this.dailylog.project_id = this.$route.params.project_id
            this.dailylog.form_id = this.$route.params.form_id
            this.init()
        },
        methods: {
            init() {
                apiProjectDailylogs.show(this.dailylog.form_id, {
                    project_id: this.dailylog.project_id,
                    is_copied: 1,
                    form_id: this.dailylog.form_id
                }).then(res => {
                    this.enabled = res.data.is_enable
                    this.dailylog = res.data.project_daily_log.length > 0
                        ? res.data.project_daily_log[0]
                        : {
                            id: null,
                            project_id: this.$route.params.project_id,
                            form_id: this.$route.params.form_id,
                            notes: '',
                            is_copied: 1
                        }
                }).catch(this.handleErrorResponse)
            },
            updateNotes: _.debounce(function() {
                if (this.dailylog.id) {
                    apiProjectDailylogs.patch(this.dailylog.id, this.dailylog)
                    .then(res => {
                    }).catch(this.handleErrorResponse)
                } else {
                    apiProjectDailylogs.store(this.dailylog)
                    .then(res => {
                        this.dailylog = res.data.projectDailylog
                    }).catch(this.handleErrorResponse)
                }
            }, 500)
        }
    }
</script>