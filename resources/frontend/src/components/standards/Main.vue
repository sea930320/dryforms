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
                        <label class="mt-3" v-text="'* ' + item.title"></label>
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
                    <b-form-checkbox v-model="addSignature" @change="setAndFilter('signature', $event)">Owner/Occupant and Company electric signature.(Select if you wich to have electric signature)</b-form-checkbox>
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
                addSignature: false,
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
            this.$on('reloadStatement', () => {
                this.setForm(this.$route.params.form_id)
            })
            this.$bus.$on('standards_save', () => {
                if (this.form.id) {
                    apiStandardForm.patch(this.form.id, this.form)
                    .then(response => {
                        this.$notify({
                            type: 'success',
                            title: 'Success',
                            text: 'Successfully saved'
                        })
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
                    }).catch(this.handleErrorResponse)
                }
            })
        },
        methods: {
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
                    this.addSignature = (this.form.signature === 1)

                    apiStandardForm.show(formID)
                        .then(response => {
                            this.$set(this.form, 'statements', response.data.statements)
                            this.isLoaded = true
                        })
                } else {
                    this.form = null
                }
            }
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
    .content-container {
        label {
            color: white;
            text-shadow: -2px 2px 10px #000000;
        }
    }
</style>