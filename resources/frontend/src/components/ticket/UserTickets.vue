<template>
    <div class="card text-center settings-account">
        <div class="card-header">
            <h5>{{ $route.meta.title }}</h5>
        </div>
        <div class="card-body text-left">
          <b-container class="">
          </b-container>
        </div>
        <div class="card-footer text-muted">
        </div>
    </div>

</template>

<script>
    import Loading from '../layout/Loading'
    import ErrorHandler from '../../mixins/error-handler'

    export default {
        name: 'CreateTicket',
        mixins: [ErrorHandler],
        components: {
            Loading
        },
        data() {
            return {
            }
        },
        created() {
        },
        methods: {
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
