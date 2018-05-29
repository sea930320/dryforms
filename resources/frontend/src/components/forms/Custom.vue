<template>
    <div class="card" style="min-height: 100vh;">
        <div class="card-body text-center">
            <form-header></form-header>
            <h4 class="mb-2">{{ form_title }}</h4>
            <div class="dropdown-divider"></div>
            <form-banner class="mt-2"></form-banner>
            <div class="dropdown-divider"></div>
            <statement></statement>            
            <notes class="mt-3"></notes>            
            <signature class="mt-3"></signature>
            <footer-text class="mt-3"></footer-text>
        </div>
    </div>
</template>

<script type="text/babel">
    import FormHeader from './FormHeader'
    import FormBanner from './FormBanner'
    import Notes from './Notes'
    import FooterText from './FooterText'
    import Signature from './Signature'
    import Statement from './Statement'
    import ErrorHandler from '../../mixins/error-handler'
    import apiForms from '../../api/forms'

    export default {
        mixins: [ErrorHandler],
        name: 'project custom',
        components: {FormHeader, FormBanner, Notes, FooterText, Signature, Statement},
        data() {
            return {
                project_id: null,
                form_id: null,
                form_title: null
            }
        },
        created() {
            this.project_id = this.$route.params.project_id
            this.form_id = this.$route.params.form_id
            apiForms.index({
                form_id: this.form_id
            }).then(res => {
                let formdata = res.data
                formdata.forEach((item) => {
                    if (item.id === this.form_id) {
                        this.form_title = item.name
                    }
                })
            }).catch(this.handleErrorResponse)
            this.$nextTick(() => {
                this.init()
            })
        },
        methods: {
            init() {
            }
        }
    }
</script>