<template>
    <div class="card" style="min-height: 100vh;">
        <div class="card-body text-center">
            <form-header></form-header>
            <h4 class="mb-2">{{ $route.meta.title }}</h4>
            <div class="dropdown-divider"></div>
            <form-banner class="mt-2"></form-banner>
            <div class="dropdown-divider"></div>
            <statement></statement>            
            <notes class="mt-3"></notes>
            <footer-text class="mt-3"></footer-text>
            <signature class="mt-3"></signature>
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

    export default {
        mixins: [ErrorHandler],
        name: 'project authorization',
        components: {FormHeader, FormBanner, Notes, FooterText, Signature, Statement},
        data() {
            return {
                authContent: '<h2>Work Authorization Data</h2>'
            }
        },
        created() {
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