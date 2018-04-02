<template>
    <div class="text-left">
        <div v-for="item in statement_infos" :key="item.id">
            <h6 class="mt-3" v-text="item.title ? item.title : 'Enter form body text'"></h6>
            <!-- <froala :tag="'textarea'" :config="config" v-model="item.statement" @input='updateStatements(item)'></froala> -->
            <div class="m-3" v-html="item.statement">
            </div>
            <hr>
        </div>
    </div>
</template>

<script type="text/babel">
    import ErrorHandler from '../../mixins/error-handler'
    import apiProjectStatement from '../../api/project_statements'
    import '../../../node_modules/froala-editor/js/froala_editor.pkgd.min'
    import _ from 'lodash'

    export default {
        mixins: [ErrorHandler],
        name: 'statement',
        data() {
            return {
                project_id: null,
                form_id: null,
                statement_infos: [],
                config: {
                    key: this.$config.get('froala_key'),
                    events: {
                        'froalaEditor.initialized': function () {
                            console.log('initialized')
                        }
                    }
                }
            }
        },
        created() {
            this.$nextTick(() => {
                this.init()
            })
        },
        methods: {
            init() {
                this.project_id = this.$route.params.project_id
                this.form_id = this.$route.params.form_id
                apiProjectStatement.index({
                    project_id: this.project_id,
                    form_id: this.form_id
                }).then(res => {
                    this.statement_infos = res.data.projectStatements
                }).catch(this.handleErrorResponse)
            },
            updateStatements: _.debounce(function(statementInfo) {
                apiProjectStatement.patch(statementInfo.id, statementInfo)
                .then(res => {
                }).catch(this.handleErrorResponse)
            }, 500)
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss"> 
    @import 'froala-editor/css/froala_editor.pkgd.min.css';
    @import 'froala-editor/css/froala_style.min.css';
    #bodyEditor {
        min-height: 500px !important;
    }
    #footerEditor {
        height: 150px !important;
    }
    .fr-box.fr-basic.fr-top .fr-wrapper {
        height: 400px;
        overflow: auto;
    }
    .info-line-bottom label {
        width: 90%;
    }
    .entry {
        background: #E5E5E5;
    }
    .info-bottom label {
        font-weight: 600;
    }
</style>