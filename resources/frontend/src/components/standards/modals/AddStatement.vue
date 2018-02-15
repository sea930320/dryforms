<template>
    <b-modal id="standardsAddStatement" :title="modalName" class="text-left" @ok="store()" v-model="show">
        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" :class="{'is-invalid': (errors.has('title'))}" v-validate data-vv-rules="required" v-model="title" placeholder="Enter statement title">
        </div>
        <template slot="modal-footer">
            <b-btn variant="primary" @click="store">
                OK
            </b-btn>
            <b-btn variant="" @click="show = false">
                Cancel
            </b-btn>
        </template>
    </b-modal>
</template>

<script type="text/babel">
    import ErrorHandler from '../../../mixins/error-handler'
    import apiStandardForm from '../../../api/standard_form'

    export default {
        mixins: [ErrorHandler],
        name: 'standards-add-statement',
        created() {
            this.$bus.$on('standards_add_statement', () => {
                this.title = ''
                this.errors.clear()
                this.show = true
            })
        },
        data() {
            return {
                show: false,
                title: ''
            }
        },
        computed: {
            modalName() {
                return 'Add New Statement'
            }
        },
        methods: {
            store() {
                this.$validator.validateAll()
                if (this.errors.any()) {
                    return
                }
                let formID = this.$route.params.form_id
                apiStandardForm.storeStatement({
                    form_id: formID,
                    title: this.title
                })
                    .then(response => {
                        this.$parent.$emit('reloadStatement')
                        this.show = false
                    })
                    .catch(this.handleErrorResponse)
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
