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
                    <input type="text" class="form-control mb-3" v-model="form.name">
                    <label>* Enter form title</label>
                    <input type="text" class="form-control" v-model="form.title">
                    <div v-for="item in form.statements" :key="item.id">
                        <label class="mt-3" v-text="item.title ? '* ' + item.title : '* Enter form body text'"></label>
                        <froala :tag="'textarea'" :config="config" v-model="item.statement"></froala>
                    </div>
                    <div class="mt-3">
                        <b-form-checkbox v-model="addNotes" @change="setAndFilter('additional_notes_show', $event)">Addtional notes.(Select if you wish to have Additional notes text box)</b-form-checkbox>  
                    </div>
                    <div>
                        <b-form-checkbox v-model="addFooter" @change="setAndFilter('footer_text_show', $event)">Footer Text.(Select if you wish to have a footer text)</b-form-checkbox> 
                        <div v-if="form.footer_text_show">
                            <froala :tag="'textarea'" id="footerEditor" :config="config" v-model="form.footer_text" class="mb-3"></froala>
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
                    <!-- <b-modal id="standardsSignature" title="Electronic Sign Pad" class="text-left" v-model="showSignature">
                        <vueSignature ref="signature" :sigOption="option" :w="'466px'" :h="'200px'"></vueSignature>
                        <template slot="modal-footer">
                            <b-btn variant="primary" @click="save">
                                Ok
                            </b-btn>
                            <b-btn variant="info" @click="clear">
                                Clear
                            </b-btn>
                            <b-btn variant="" @click="showSignature = false">
                                Cancel
                            </b-btn>
                        </template>
                    </b-modal> -->
                </b-container>
            </div>
            <div class="card-footer"></div>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import Loading from '../layout/Loading'
    import ErrorHandler from '../../mixins/error-handler'
    import AddStatement from './modals/AddStatement'
    import '../../../node_modules/froala-editor/js/froala_editor.pkgd.min'

    import apiStandardForm from '../../api/standard_form'

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
                }
                // showSignature: false,
                // modal_type: '',
                // option: {
                //     penColor: 'rgb(0, 0, 0)'
                // }
            }
        },
        created() {
            this.$on('reloadStatement', () => {
                this.setForm(this.$route.params.form_id)
            })
            this.$bus.$on('standards_save', this.save)
        },
        methods: {
            save() {
                if (this.form.id) {
                    apiStandardForm.patch(this.form.id, this.form)
                    .then(response => {
                        this.$notify({
                            type: 'success',
                            title: 'Success',
                            text: 'Successfully saved'
                        })
                        this.setForm(this.$route.params.form_id)
                    }).catch(this.handleErrorResponse)
                } else {
                    apiStandardForm.store(this.form)
                    .then(response => {
                        this.form.id = response.data.form.id
                        this.$notify({
                            type: 'success',
                            title: 'Success',
                            text: 'Successfully saved'
                        })
                        this.setForm(this.$route.params.form_id)
                    }).catch(this.handleErrorResponse)
                }
            },
            setAndFilter(field, value) {
                this.form[field] = (value ? 1 : 0)
                if (field === 'footer_text_show' && !value) this.form.footer_text = null
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
            removeStatement(id) {
                apiStandardForm.deleteStatement(id)
                    .then(response => {
                        this.setForm(this.$route.params.form_id)
                    })
                    .catch(this.handleErrorResponse)
            }
            // signatureModal(type) {
            //     this.modal_type = type
            //     document.querySelector('#standardsSignature canvas').setAttribute('width', '466')
            //     document.querySelector('#standardsSignature canvas').setAttribute('height', '200')
            //     this.showSignature = true
            // },
            // save() {
            //     var _this = this
            //     debugger
            //     var png = _this.$refs.signature.save()
            //     if (_this.$refs.signature.isEmpty()) {
            //         png = ''
            //     }
            //     if (_this.modal_type === 'insured') {
            //         _this.form.insured_signature = png
            //     } else {
            //         _this.form.company_signature = png
            //     }
            //     _this.showSignature = false
            // },
            // clear() {
            //     var _this = this
            //     _this.$refs.signature.clear()
            // }
        },
        beforeDestroy () {
            this.$bus.$off('standards_save', this.save)
        },
        watch: {
            '$store.state.StandardForm.formsOrder': function() {
                this.isLoaded = false
                this.setForm(this.$route.params.form_id)
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