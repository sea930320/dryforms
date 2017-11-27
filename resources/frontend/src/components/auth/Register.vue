<template>
    <div class="card text-center">
        <div class="card-header">
            Register
        </div>
        <div class="card-body text-left">
            <form>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" v-model="user.first_name">
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" v-model="user.lastName">
                </div>
                <div class="form-group">
                    <label>Street Address</label>
                    <input type="text" class="form-control" v-model="user.address">
                </div>
                <div class="form-group">
                    <label>Street Address</label>
                    <input type="text" class="form-control" v-model="user.address">
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" class="form-control" v-model="user.city">
                </div>
                <div class="form-group">
                    <label>State</label>
                    <input type="text" class="form-control" v-model="user.state">
                </div>
                <div class="form-group">
                    <label>Zip Code</label>
                    <input type="text" class="form-control" v-model="user.zip">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" class="form-control" v-model="user.phone">
                </div>
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" class="form-control" placeholder="Enter email" v-model="user.email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password" v-model="user.password">
                </div>
                <div class="form-group">
                    <label>Password Confirmation</label>
                    <input type="password" class="form-control" placeholder="Password" v-model="user.passwordConfirmation">
                </div>
            </form>
        </div>
        <div class="card-footer text-muted">
            <button class="btn btn-primary" @click.prevent="register()">Register</button>
        </div>
    </div>
</template>

<script type="text/babel">
    import axios from 'axios'
    import apiAuth from '../../api/auth'

    export default {
        name: 'Register',
        data() {
            return {
                user: {}
            }
        },
        methods: {
            register() {
                apiAuth.register(this.user)
                    .then(response => {
                        this.$session.start()
                        this.$session.set('apiToken', response.data.token)
                        axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token
                        this.$router.push('/')
                    })
                    .catch(error => {
                        let messages = null
//                        _.each(error.data, (message) => {
//                            messages += message[0]
//                        })
                        this.$notify({
                            type: 'error',
                            title: 'Important message',
                            text: messages
                        })
                    })
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
