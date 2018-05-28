<template>
    <div class="standards-main">        
        <div class="card text-center">
            <div class="card-header">
                <h5> Build A New Form </h5>
                <button class="btn pull-right btn-create" @click="buildForm()"><i class="fa fa-plus"></i></button>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-container class="content-container">
                    <label>* Enter a new form name</label>
                    <input type="text" class="form-control mb-3" v-model="form_name">
                    <label>* Enter side menu name</label>
                    <input type="text" class="form-control mb-3" v-model="form_menuname">
                    <label>* Enter form title</label>
                    <input type="text" class="form-control" v-model="form_title">
                    <div v-for="(item,index) in statements" :key="index">
                        <div class="mt-3 mb-1">
                            <label >{{item.title}}</label>
                            <button class="btn btn-sm btn-danger pull-right" @click="deleteStatement(index)">Delete Statement</button>
                        </div>
                        <froala :tag="'textarea'" :config="config" v-model="item.statement"></froala>                        
                    </div>
                    <div class="mt-3 mb-1">
                        <button class="btn btn-sm btn-info pull-right" @click="showStatementModal">Add Statement</button>
                    </div>
                    <div class="mt-3">
                        <b-form-checkbox v-model="addNotes">Addtional notes.(Select if you wish to have Additional notes text box)</b-form-checkbox>  
                    </div>
                    <div>
                        <b-form-checkbox v-model="addFooter">Footer Text.(Select if you wish to have a footer text)</b-form-checkbox> 
                        <div v-if="addFooter == true">
                            <froala :tag="'textarea'" id="footerEditor" :config="config" v-model="footer_text" class="mb-3"></froala>
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
                            <div class="info-line-bottom">
                                <label>Signature</label>
                                <label class="entry">&nbsp;</label>
                            </div>
                            <div class="info-line-bottom">
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
        <b-modal ref="addstatementModalRef" title="Add Statement" @ok="addStatement">
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" class="form-control" v-model="newtitle" placeholder="Enter statement title">
            </div>
        </b-modal>
    </div>
</template>

<script type="text/babel">
    import ErrorHandler from '../../mixins/error-handler'
    import apiForms from '../../api/forms'
    import '../../../node_modules/froala-editor/js/froala_editor.pkgd.min'
    export default {
        mixins: [ErrorHandler],
        data () {
            return {
                form_name: null,
                form_menuname: null,
                form_title: null,
                newtitle: null,
                statements: [],
                count: 0,
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
        },
        methods: {
            showStatementModal() {
                this.$refs.addstatementModalRef.show()
            },
            addStatement() {
                this.statements.push({title: this.newtitle, statement: ''})
            },
            deleteStatement(Id) {
                this.statements.splice(Id, 1)
            },
            buildForm() {
                apiForms.store({
                    form_name: this.form_name,
                    form_menuname: this.form_menuname,
                    form_title: this.form_title,
                    addNotes: this.addNotes,
                    addFooter: this.addFooter,
                    statements: this.statements
                }).then(res => {
                    this.$notify({
                        type: 'success',
                        text: res.data.message
                    })
                }).catch(this.handleErrorResponse)
            }
        },
        watch: {
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
    .card-header {
        position: relative;
        .btn-create {
            position: absolute;
            top: 0px;
            bottom: 0px;
            right: 0px;
            font-size: 15px;
        }
    }
</style>