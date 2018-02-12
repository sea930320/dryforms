<template>
    <div class="standards-main">
        <div class="card text-left" v-if="isLoaded">
            <div class="card-header text-center">
                <h5> {{form.name}} </h5>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-container class="">
                    <label>* Enter side menu name</label>
                    <input type="text" class="form-control mb-3" v-model="form.name">
                    <label>* Enter form title</label>
                    <input type="text" class="form-control" v-model="form.title">
                    <label class="mt-3">* Enter form body text</label>
                    <froala :tag="'textarea'" :config="config" v-model="form.statement"></froala>
                    <div class="mt-3">
                        <b-form-checkbox v-model="addNotes">Addtional notes.(Select if you wish to have Additional notes text box)</b-form-checkbox>  
                    </div>
                    <div>
                        <b-form-checkbox v-model="addFooter">Footer Text.(Select if you wish to have a footer text)</b-form-checkbox> 
                        <!-- <vue-editor id="footerEditor" v-model="footerText" v-if="addFooter" class="mb-3"></vue-editor> -->
                        <div v-if="addFooter">
                        <froala :tag="'textarea'" id="footerEditor" :config="config" v-model="footerText" class="mb-3"></froala>
                        </div>
                    </div>      
                    <b-form-checkbox v-model="addSignature">Owner/Occupant and Company electric signature.(Select if you wich to have electric signature)</b-form-checkbox>
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
    import { VueEditor } from 'vue2-editor'

    import '../../../node_modules/froala-editor/js/froala_editor.pkgd.min'

    export default {
        mixins: [ErrorHandler],
        components: { VueEditor, Loading },
        data () {
            return {
                addNotes: false,
                addFooter: false,
                addSignature: false,
                footerText: 'Please call in the event of an Emergency or if you have any questions. I have read and understand the information above.',
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
        computed: {
            formPerID: function() {
                return this.$store.getters.formPerID(this.$route.params.form_id)
            },
            isLoaded: function() {
                return this.formPerID.length !== 0
            },
            form: function() {
                if (this.formPerID.length !== 0) {
                    return this.formPerID[0].standard_form[0]
                } else {
                    return ''
                }
            }
        },
        created() {
        },
        methods: {
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
</style>