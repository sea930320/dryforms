<template>
    <b-modal id="createDailylog" title="Add Daily Log" class="text-left" @ok="store()" v-model="show">
        <div class="form-group">
            <label>Additional notes:</label>
            <b-form-textarea class="form-control" :rows="3" v-model='dailylog.notes'></b-form-textarea>
        </div>
    </b-modal>
</template>

<script type="text/babel">
    import ErrorHandler from '../../../mixins/error-handler'
    import apiProjectDailylogs from '../../../api/project_dailylog'

    export default {
        mixins: [ErrorHandler],
        name: 'create-dailylog-modal',
        created() {
            this.$parent.$on('openCreateDailyLogModal', () => {
                this.dailylog = {
                    is_copied: 0,
                    form_id: this.$route.params.form_id,
                    notes: null,
                    project_id: this.$route.params.project_id
                }
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                dailylog: {
                    is_copied: 0,
                    form_id: this.$route.params.form_id,
                    notes: null,
                    project_id: this.$route.params.project_id
                }
            }
        },
        methods: {
            store() {
                apiProjectDailylogs.store(this.dailylog)
                    .then(res => {
                        this.$parent.$emit('reloadData')
                    }).catch(this.handleErrorResponse)
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>