<template>
    <div class="standards-main">        
        <div class="card text-left" v-if="isLoaded">
            <add-statement></add-statement>
            <div class="card-header text-center">
                <h5> {{form.name}} </h5>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-container class="content-container">
                    <label>* Enter side menu name</label>
                    <input type="text" class="form-control mb-3" v-model="form.name" @input="save">
                    <label>* Enter form title</label>
                    <input type="text" class="form-control" v-model="form.title" @input="save">
                    <div v-for="(item, index) in form.statements" :key="item.id">
                        <div class="mt-3 mb-1">
                            <label v-text="item.title ? '* ' + item.title : '* Enter form body text'"></label>
                            <button class="btn btn-sm btn-info pull-right" @click="showRevertConfirm(index)">Revert</button>
                        </div>
                        <froala :tag="'textarea'" :config="config" v-model="item.statement" @input="save"></froala>                        
                    </div>
                    <div class="mt-3">
                        <b-form-checkbox v-model="addNotes" @change="setAndFilter('additional_notes_show', $event)">Addtional notes.(Select if you wish to have Additional notes text box)</b-form-checkbox>  
                    </div>
                    <div>
                        <b-form-checkbox v-model="addFooter" @change="setAndFilter('footer_text_show', $event)">Footer Text.(Select if you wish to have a footer text)</b-form-checkbox> 
                        <div v-if="form.footer_text_show">
                            <froala :tag="'textarea'" id="footerEditor" :config="config" v-model="form.footer_text" class="mb-3" @input="save"></froala>
                        </div>
                    </div>
                    <b-row class="info-bottom mt-3">
                        <b-col cols="4">
                            <div class="info-line-bottom">
                                <label>Insured</label>
                                <label class="entry">&nbsp;</label>
                            </div>
                            <div class="info-line-bottom">
                                <label>Company</label>
                                <label class="entry">&nbsp;</label>
                            </div>
                        </b-col>
                        <b-col cols="4">
                            <div class="info-line-bottom" @click="signatureModal('insured')">
                                <label>Signature</label>
                                <label class="entry">&nbsp;</label>
                            </div>
                            <div class="info-line-bottom" @click="signatureModal('company')">
                                <label>Signature</label>
                                <label class="entry">&nbsp;</label>
                            </div>
                        </b-col>
                        <b-col cols="4">
                            <div class="info-line-bottom">
                                <label>Date</label>
                                <label class="entry">&nbsp;</label>
                            </div>
                            <div class="info-line-bottom">
                                <label>Date</label>
                                <label class="entry">&nbsp;</label>
                            </div>
                        </b-col>
                    </b-row>
                </b-container>
            </div>
            <div class="card-footer"></div>
        </div>
        <loading v-else></loading>
        <b-modal id="rejectStatement" title="Revert Statement" class="text-left" @ok="revertStatement()" v-model="show"
                :ok-title="'Confirm'" :ok-variant="'danger'">
            <h5>Are you sure you want to revert to the default statement?</h5>
        </b-modal>
    </div>
</template>

<script type="text/babel">
    import Loading from '../layout/Loading'
    import ErrorHandler from '../../mixins/error-handler'
    import AddStatement from './modals/AddStatement'
    import '../../../node_modules/froala-editor/js/froala_editor.pkgd.min'

    import apiStandardForm from '../../api/standard_form'
    import _ from 'lodash'

    export default {
        mixins: [ErrorHandler],
        components: { Loading, AddStatement },
        data () {
            return {
                form: null,
                isLoaded: false,
                addNotes: false,
                addFooter: false,
                config: {
                    key: this.$config.get('froala_key'),
                    events: {
                        'froalaEditor.initialized': function () {
                            console.log('initialized')
                        }
                    }
                },
                revertingIndex: null,
                show: false
            }
        },
        created() {
            this.$on('reloadStatement', () => {
                this.setForm(this.$route.params.form_id)
            })
            // this.$bus.$on('standards_save', this.save)
        },
        methods: {
            save: _.debounce(function () {
                if (this.form.id) {
                    apiStandardForm.patch(this.form.id, this.form)
                    .then(response => {
                        this.setForm(this.$route.params.form_id)
                    }).catch(this.handleErrorResponse)
                } else {
                    apiStandardForm.store(this.form)
                    .then(response => {
                        this.form.id = response.data.form.id
                        this.setForm(this.$route.params.form_id)
                    }).catch(this.handleErrorResponse)
                }
            }, 500),
            setAndFilter(field, value) {
                this.form[field] = (value ? 1 : 0)
                if (field === 'footer_text_show' && !value) this.form.footer_text = null
                this.save()
            },
            setForm(formID) {
                let formPerID = this.$store.getters.formPerID(formID)
                if (formPerID.length !== 0) {
                    this.form = formPerID[0].standard_form[0]
                    this.addNotes = (this.form.additional_notes_show === 1)
                    this.addFooter = (this.form.footer_text_show === 1)
                    apiStandardForm.show(formID)
                        .then(response => {
                            let statements = response.data.statements
                            if (statements.length === 0) {
                                statements = formPerID[0].default_statements
                            }
                            this.$set(this.form, 'statements', statements)
                            this.isLoaded = true
                        })
                } else {
                    this.form = null
                }
            },
            showRevertConfirm(index) {
                this.revertingIndex = index
                this.show = true
            },
            revertStatement() {
                let formPerID = this.$store.getters.formPerID(this.$route.params.form_id)
                let defaultStatements = formPerID[0].default_statements
                this.$set(this.form.statements[this.revertingIndex], 'statement', defaultStatements[this.revertingIndex].statement)
            },
            removeStatement(id) {
                apiStandardForm.deleteStatement(id)
                    .then(response => {
                        this.setForm(this.$route.params.form_id)
                    })
                    .catch(this.handleErrorResponse)
            }
        },
        beforeDestroy () {
            // this.$bus.$off('standards_save', this.save)
        },
        watch: {
            '$store.state.StandardForm.formsOrder': function() {
                this.isLoaded = false
                this.setForm(this.$route.params.form_id)
                console.log('sdf')
            }
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
    // .info-bottom img {
    //     height: 30px;
    //     margin-bottom: 8px;
    // }
    #standardsSignature .modal-dialog {
        width: 500px !important;
    }
</style>