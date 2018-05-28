<template>
    <b-row>
        <b-col v-html="footerText" class="text-center"></b-col>
    </b-row>
</template>

<script type="text/babel">
    import ErrorHandler from '../../mixins/error-handler'
    import apiProjectFooterText from '../../api/project_footer_text'

    export default {
        mixins: [ErrorHandler],
        name: 'footer-text',
        data() {
            return {
                footerText: ''
            }
        },
        created() {
            apiProjectFooterText.index({
                form_id: this.$route.params.form_id
            }).then(res => {
                if (res.data.message === 'invisible') {
                    this.footerText = ''
                } else {
                    this.footerText = res.data.standardForm.footer_text
                }
            }).catch(this.handleErrorResponse)
        },
        watch: {
            '$route' (to, from) {
                apiProjectFooterText.index({
                form_id: this.$route.params.form_id
                }).then(res => {
                    if (res.data.message === 'invisible') {
                        this.footerText = ''
                    } else {
                        this.footerText = res.data.standardForm.footer_text
                    }
                }).catch(this.handleErrorResponse)
            }
        }
    }
</script>