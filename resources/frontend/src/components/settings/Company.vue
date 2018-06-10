<template>
    <div class="settings-company">
        <!-- <my-upload field="img"
          width="180"
          height="81"
          url=""
          lang-type="en"
          v-model="image.show"
          @crop-success="cropSuccess"
          @input="eventOnMyUpload"
          img-format="png"></my-upload> -->
        <div class="card text-center" v-if="isLoaded">
            <cancel-subscription-modal></cancel-subscription-modal>
            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-container class="">
                    <form @submit.prevent="validateBeforeSubmit">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group logo-preview"  v-if="company.logo">
                                    <img :src="company.logo" height="90"> <br/>
                                    <button class="btn btn-sm mt-2" @click.prevent="removeImage">Remove Logo</button>
                                </div>
                                <div v-else class="form-group">
                                    <!-- <button class="btn btn-sm" @click.prevent="imageUpload">
                                      {{company.logo? 'Reset Company Logo' : 'Set Company Logo'}}</button> -->
                                    <label for="file-upload" class="custom-file-upload">
                                        <i class="fa fa-cloud-upload"></i> Set Company Logo
                                    </label>
                                    <input id="file-upload" type="file" @change="onFileChange"/>
                                </div>
                                <div class="form-group">
                                    <label>Company Name:</label>
                                    <b-form-input :size="template_size" type="text" v-model="company.name" name="name" placeholder="Input Company Name" :class="{'is-invalid': errors.has('name')}" v-validate data-vv-rules="required"/>
                                </div>
                                <div class="form-group">
                                    <label>Street Address:</label>
                                    <b-form-input :size="template_size" type="text" v-model="company.street" name="street" placeholder="Input Street Address" :class="{'is-invalid': errors.has('street')}" v-validate data-vv-rules="required"/>
                                </div>
                                <div class="form-group">
                                    <label>City:</label>
                                    <b-form-input :size="template_size" type="text" v-model="company.city" name="city" placeholder="Input City" :class="{'is-invalid': errors.has('city')}" v-validate data-vv-rules="required"/>
                                </div>
                                <div class="form-group">
                                    <label>State:</label>
                                    <select class="form-control form-control-sm" v-model="company.state" name="state" :class="{'is-invalid': errors.has('state')}" v-validate data-vv-rules="required">
                                        <option :value="null">-- Please select --</option>
                                        <option v-for="item in states" v-bind:key="item.value" :value="item.value">{{ item.text }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Zip Code:</label>
                                    <b-form-input :size="template_size" type="number" v-model="company.zip" name="zip" placeholder="Input Zip Code" :class="{'is-invalid': errors.has('zip')}" v-validate data-vv-rules="required"/>
                                </div>
                                <div class="form-group">
                                    <label>Phone:</label>
                                    <masked-input class="form-control form-control-sm" v-model="company.phone" mask="(111) 111-1111" placeholder="(702) 555-1212"  name="phone" :class="{'is-invalid': !company.phone}" v-validate data-vv-rules="required"/>
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <b-form-input :size="template_size" type="text" v-model="company.email" name="email" placeholder="Input Email Address" :class="{'is-invalid': errors.has('email')}" v-validate data-vv-rules="required"/>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group row mr-0">
                                    <div class="col-lg-12 mb-1 col-xl-6" v-if="!isGracePeriod">
                                      <input type="button" class="btn btn-sm btn-primary float-left" @click.prevent="gotoCreditCard" :disabled="pending.cancel" value="Update Credit Card Info"/>
                                    </div>
                                    <div class="col-lg-12 mb-1 col-xl-4" v-if="isSubscribed && !isGracePeriod">
                                      <input type="button" class="btn btn-sm btn-danger float-left" @click.prevent="cancelSubscription" :disabled="pending.cancel" value="Cancel Subscription"/>
                                      <input type="button" class="btn btn-sm float-left" @click.prevent="getInvoices" :disabled="pending.cancel" value="Get Invoices"/>
                                    </div>
                                    <div class="col-lg-12 mb-1 col-xl-4" v-else-if="isSubscribed && isGracePeriod">
                                      <input type="button" class="btn btn-sm float-left" @click.prevent="resumeSubscription" :disabled="pending.resume" value="Resume Subscription"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Cloud Link:</label>
                                    <b-form-input :size="template_size" type="text" v-model="company.cloud_link" placeholder="Cloud Link"/>
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-sm btn-primary" :disabled="pending.update" value="Submit">
                    </form>
                </b-container>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import myUpload from 'vue-image-crop-upload'
    import MaskedInput from 'vue-masked-input'

    import Loading from '../layout/Loading'
    import apiAccount from '../../api/account'
    import apiCompanies from '../../api/companies'
    import CancelSubscriptionModal from './modals/CancelSubscriptionModal'
    import { mapActions } from 'vuex'

    export default {
        name: 'Company',
        components: {
          Loading, myUpload, MaskedInput, CancelSubscriptionModal
        },
        data() {
            return {
              states: null,
              image: {
                show: false
              },
              pending: {
                  update: false,
                  cancel: false,
                  resume: false
              }
            }
        },
        created() {
            let jsonStates = this.$config.get('states')
            this.states = Object.keys(jsonStates).map(function(key) {
                return {
                  value: key,
                  text: jsonStates[key]
                }
            })
            this.fetchUser()
            this.$on('continueCancel', (payload) => {
                this.continueCancel(payload.feedback)
            })
        },
        methods: {
            ...mapActions([
                'fetchUser'
            ]),
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files
                if (!files.length) return
                this.createImage(files[0])
            },
            createImage(file) {
                var reader = new FileReader()
                var vm = this

                reader.onload = (e) => {
                    vm.company.logo = e.target.result
                }
                reader.readAsDataURL(file)
            },
            removeImage: function (e) {
                this.company.logo = ''
            },
            generateLogoToBase64() {
                var _this = this
                let logo = this.company.logo
                this.company.logo = ''

                var canvas = document.createElement('CANVAS')
                var img = document.createElement('img')
                img.src = this.logoRootPath + 'settings/logo/' + logo
                img.onload = function () {
                    canvas.height = img.height
                    canvas.width = img.width
                    let context = canvas.getContext('2d')
                    context.drawImage(img, 0, 0)
                    _this.$set(_this.company, 'logo', canvas.toDataURL('image/png'))
                    canvas = null
                }
                img.onerror = function (error) {
                    this.handleErrorResponse(error)
                }
            },
            cropSuccess(imgDataUrl, field) {
                this.company.logo = imgDataUrl
                this.image.show = false
            },
            eventOnMyUpload(event) {
                if (!event) {
                    this.image.show = false
                }
            },
            imageUpload() {
                this.image.show = !this.image.show
            },
            validateBeforeSubmit() {
                this.$validator.validateAll()
                if (this.errors.any() || !this.company.phone) {
                  return
                }
                this.update()
            },
            gotoCreditCard() {
                this.$router.push({name: 'CreditCard'})
            },
            cancelSubscription() {
                this.$emit('openCancelSubscriptionModal')
            },
            getInvoices() {
                apiAccount.getInvoices()
                    .then(response => {
                        this.fetchUser()
                        console.log(response.data)
                    })
                    .catch(self.handleErrorResponse)
            },
            continueCancel(feedback) {
                this.pending.cancel = true
                apiAccount.cancelSubscribe({feedback: feedback})
                    .then(response => {
                        this.fetchUser()
                        this.pending.cancel = false
                    })
                    .catch(self.handleErrorResponse)
            },
            resumeSubscription() {
                this.pending.resume = true
                apiAccount.resumeSubscribe()
                    .then(response => {
                        this.fetchUser()
                        this.pending.resume = false
                    })
                    .catch(self.handleErrorResponse)
            },
            update() {
                this.pending.update = true
                apiAccount.userInformation()
                    .then(response => {
                      apiCompanies.patch(response.data.user.company_id, this.company)
                          .then(response => {
                                this.$notify({
                                    type: 'info',
                                    title: response.data.message
                                })
                                this.pending.update = false
                          })
                          .catch(error => {
                              console.log(error)
                          })
                    })
            }
        },
        computed: {
          company: function() {
              return this.$store.state.User.company
          },
          isSubscribed: function() {
              return this.$store.state.User.isSubscribed
          },
          isGracePeriod: function() {
              return this.$store.state.User.isGracePeriod
          },
          isLoaded: function() {
              if (this.company.length !== 0) {
                  if (this.company.logo && this.company.logo.indexOf('data:image/png;') === -1) {
                      this.generateLogoToBase64()
                  }
                  return true
              }
              return false
          }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    input[type="file"]#file-upload {
        display: none;
    }
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 3px 12px;
        cursor: pointer;
    }
</style>
