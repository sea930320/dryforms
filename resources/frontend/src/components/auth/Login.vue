<template>
    <div class="card text-center">
        <div class="card-header">
            <h4>Login</h4>
        </div>
        <div class="card-body">
            <form class="text-right mt-5">
                <div class="form-group row mt-3">
                    <label class="col-md-3 col-form-label">Email address</label>
                    <input type="email" class="form-control col-md-6" aria-describedby="emailHelp" placeholder="Enter email" v-model="user.email">
                </div>
                <div class="form-group row mt-3">
                    <label class="col-md-3 col-form-label">Password</label>
                    <input type="password" class="form-control col-md-6" placeholder="Password" v-model="user.password">
                </div>
                <div class="form-group row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <b-checkbox class="float-left" v-model="remember"> Remember me</b-checkbox>
                        <b-button variant="link" class="float-right">Forgot password?</b-button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <b-button variant="primary" @click="login">Log In</b-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script type="text/babel">
    import authorization from '../../mixins/authorization'

    export default {
        name: 'Login',
        mixins: [authorization],
        data() {
            return {
                remember: false,
                user: {
                    email: null,
                    password: null
                }
            }
        },
        created () {},
        methods: {}
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
