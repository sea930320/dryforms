<template>
    <div class="card text-center">
        <div class="card-header">
            Login
        </div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" class="form-control" aria-describedby="emailHelp"
                           placeholder="Enter email" v-model="user.email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password" v-model="user.password">
                </div>
            </form>
        </div>
        <div class="card-footer text-muted">
            <button class="btn btn-primary">Log In</button>
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        name: 'Login',
        data() {
            return {
                user: {
                    email: null,
                    password: null
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>