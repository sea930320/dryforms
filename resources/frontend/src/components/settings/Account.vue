<template>
    <div class="card text-center">
        <div class="card-header">
            {{ $route.meta.title }}
        </div>
        <div class="card-body text-left">
            <form>
                <div class="form-group">
                    <label>Old Password:</label>
                    <input type="password" class="form-control" placeholder="Password" v-model="passwordData.oldPassword">
                </div>
                <div class="form-group">
                    <label>New Password:</label>
                    <input type="password" class="form-control" placeholder="Password" v-model="passwordData.newPassword">
                </div>
                <div class="form-group">
                    <label>New Password Confirmation:</label>
                    <input type="password" class="form-control" placeholder="Password" v-model="passwordData.newPasswordConfirmation">
                </div>

                <button class="btn btn-sm btn-primary" v-on:click="">Submit</button>

                <hr>
                <div class="form-group">
                    <label>Old email:</label>
                    <input type="email" class="form-control" aria-describedby="emailHelp"
                           placeholder="Enter email" v-model="emailData.oldEmail">
                </div>
                <div class="form-group">
                    <label>New email:</label>
                    <input type="email" class="form-control" aria-describedby="emailHelp"
                           placeholder="Enter email" v-model="emailData.newEmail">
                </div>

                <button class="btn btn-sm btn-primary" v-on:click="changeEmail()">Submit</button>
            </form>
        </div>
        <div class="card-footer text-muted">

        </div>
    </div>
</template>

<script type="text/babel">
    import apiAccount from '../../api/account'

    export default {
        name: 'Settings',
        data() {
            return {
                passwordData: {
                    oldPassword: null,
                    newPassword: null,
                    newPasswordConfirmation: null
                },
                emailData: {
                    oldEmail: null,
                    newEmail: null
                }
            }
        },
        methods: {
            changeEmail() {
                apiAccount.changeEmail(this.emailData)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(error => {
                        console.log(error.response)
                    })
            },
            changePassword() {

            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>