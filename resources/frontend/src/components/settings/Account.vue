<template>
    <div class="card text-center settings-account">
        <div class="card-header">
            <h5>{{ $route.meta.title }}</h5>
        </div>
        <div class="card-body text-left">
          <b-container class="">
            <form @submit.prevent="validateBeforeSubmit('form-password')" data-vv-scope="form-password">
                <div class="form-group">
                    <label>Old Password:</label>
                    <input type="password" name="Old Password" class="form-control form-control-sm" :class="{'is-invalid': errors.has('Old Password')}" v-validate data-vv-rules="required|min:8" placeholder="Enter Old Password" v-model="passwordData.old_password">
                    <p class="text-danger" v-if="errors.has('Old Password')">{{ errors.first('Old Password') }}</p>
                </div>
                <div class="form-group">
                    <label>New Password:</label>
                    <input type="password" name="New Password" class="form-control form-control-sm" :class="{'is-invalid': errors.has('New Password')}" v-validate data-vv-rules="required|min:8|confirmed:ConfirmationPassword" placeholder="Enter New Password" v-model="passwordData.new_password">
                    <p class="text-danger" v-if="errors.has('New Password')">{{ errors.first('New Password') }}</p>
                </div>
                <div class="form-group">
                    <label>New Password Confirmation:</label>
                    <input type="password" data-vv-as="Confirmation Password" name="ConfirmationPassword" class="form-control form-control-sm" :class="{'is-invalid': errors.has('ConfirmationPassword')}" v-validate data-vv-rules="required|min:8"  placeholder="Enter Confirmation Password" v-model="passwordData.new_password_confirmation">
                    <p class="text-danger" v-if="errors.has('ConfirmationPassword')">{{ errors.first('ConfirmationPassword') }}</p>
                </div>
                <b-alert :show="alertPassword.dismissCountDown"
                  @dismissed="alertPassword.dismissCountDown=0"
                  :variant="alertPassword.isErr?'danger':'success'">
                  <div v-html="alertPassword.message"> </div>
                </b-alert>
                <button type="submit" class="btn btn-sm btn-primary" :disabled="isPendingPassword">Submit</button>
            </form>
                <hr>
            <form @submit.prevent="validateBeforeSubmit('form-email')" data-vv-scope="form-email">
                <div class="form-group">
                    <label>Old Email:</label>
                    <input type="email" name="Old Email" class="form-control form-control-sm" :class="{'is-invalid': errors.has('Old Email')}" v-validate data-vv-rules="required|email" placeholder="Enter Old Email" v-model.trim="emailData.old_email">
                    <p class="text-danger" v-if="errors.has('Old Email')">{{ errors.first('Old Email') }}</p>
                </div>
                <div class="form-group">
                    <label>New Email:</label>
                    <input type="email" name="New Email" class="form-control form-control-sm" :class="{'is-invalid': errors.has('New Email')}" v-validate data-vv-rules="required|email|confirmed:ConfirmationEmail" placeholder="Enter New Email" v-model.trim="emailData.new_email">
                    <p class="text-danger" v-if="errors.has('New Email')">{{ errors.first('New Email') }}</p>
                </div>
                <div class="form-group">
                    <label>New Email Confirmation:</label>
                    <input type="email" data-vv-as="Confirmation Email" name="ConfirmationEmail" class="form-control form-control-sm" :class="{'is-invalid': errors.has('ConfirmationEmail')}" v-validate data-vv-rules="required|email" placeholder="Enter Confirmation Email" v-model="emailData.new_email_confirmation">
                    <p class="text-danger" v-if="errors.has('ConfirmationEmail')">{{ errors.first('ConfirmationEmail') }}</p>
                </div>
                <b-alert :show="alertEmail.dismissCountDown"
                  @dismissed="alertEmail.dismissCountDown=0"
                  :variant="alertEmail.isErr?'danger':'success'">
                  <div v-html="alertEmail.message"> </div>
                </b-alert>
                <button type="submit" class="btn btn-sm btn-primary" :disabled="isPendingEmail">Submit</button>
            </form>
          </b-container>
        </div>
        <div class="card-footer text-muted">

        </div>
    </div>
</template>

<script>
    import apiAccount from '../../api/account'

    export default {
        name: 'Settings',
        data() {
            return {
                passwordData: {
                    old_password: null,
                    new_password: null,
                    new_password_confirmation: null
                },
                emailData: {
                    old_email: null,
                    new_email: null,
                    new_email_confirmation: null
                },
                dismissSecs: 3,
                alertEmail: {
                    dismissCountDown: 0,
                    isErr: false,
                    message: ''
                },
                alertPassword: {
                    dismissCountDown: 0,
                    isErr: false,
                    message: ''
                },
                isPendingEmail: false,
                isPendingPassword: false
            }
        },
        methods: {
            changeEmail() {
                this.isPendingEmail = true
                apiAccount.changeEmail(this.emailData)
                    .then(response => {
                        this.alertEmail = {
                          dismissCountDown: this.dismissSecs,
                          isErr: false,
                          message: response.data.message
                        }
                        this.emailData = {
                            old_email: null,
                            new_email: null,
                            new_email_confirmation: null
                        }
                        this.isPendingEmail = false
                    })
                    .catch(error => {
                        let data = Object.entries(error.data)
                        var errMsg = ''
                        for (let ele of data) {
                            errMsg += ('<br>' + ele[1])
                        }
                        this.alertEmail = {
                            dismissCountDown: this.dismissSecs,
                            isErr: true,
                            message: errMsg.substring(4)
                        }
                        this.isPendingEmail = false
                    })
            },
            changePassword() {
                this.isPendingPassword = true
                apiAccount.changePassword(this.passwordData)
                    .then(response => {
                        this.alertPassword = {
                          dismissCountDown: this.dismissSecs,
                          isErr: false,
                          message: response.data.message
                        }
                        this.passwordData = {
                            old_password: null,
                            new_password: null,
                            new_password_confirmation: null
                        }
                        this.isPendingPassword = false
                    })
                    .catch(error => {
                        let data = Object.entries(error.data)
                        var errMsg = ''
                        for (let ele of data) {
                            errMsg += ('<br>' + ele[1])
                        }
                        this.alertPassword = {
                            dismissCountDown: this.dismissSecs,
                            isErr: true,
                            message: errMsg.substring(4)
                        }
                        this.isPendingPassword = false
                    })
            },
            validateBeforeSubmit(scope) {
                this.errors.clear()
                this.$validator.validateAll(scope)
                if (!this.errors.any()) {
                    if (scope !== 'form-email') {
                        this.changePassword()
                    } else {
                        this.changeEmail()
                    }
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
