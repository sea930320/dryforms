<template>
    <b-row>
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
                apiProjectDailylogs.index({
                    project_id: this.dailylog.project_id,
                    is_copied: 1,
                    form_id: this.dailylog.form_id
                }).then(res => {
                    if (res.data.length > 0) {
                        this.dailylog = res.data[0]
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