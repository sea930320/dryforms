<template>
    <div class="settings-company">
        <my-upload field="img"
          width="180"
          height="81"
          url=""
          lang-type="en"
          v-model="image.show"
          @crop-success="cropSuccess"
          @input="eventOnMyUpload"
          img-format="png"></my-upload>
        <div class="card text-center" v-if="isLoaded">
            <div class="card-header">
                <h5>Company Register</h5>
            </div>
            <div class="card-body text-left pt-3 pb-3">
                <b-container class="">
                    <form @submit.prevent="validateBeforeSubmit">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group logo-preview"  v-if="company.logo">
                                    <img :src="company.logo" height="90">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-sm" @click.prevent="imageUpload">
                                      {{company.logo? 'Reset Company Logo' : 'Set Company Logo'}}</button>
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
    import apiCompanies from '../../api/companies'
    export default {
        name: 'Company',
        components: {
          Loading, myUpload, MaskedInput
        },
        data() {
            return {
              company: [],
              states: null,
              image: {
                show: false
              },
              pending: {
                  update: false,
                  cancel: false,
                  resume: false
              },
              isLoaded: false
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
            this.isLoaded = true
        },
        methods: {
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
            update() {
                this.pending.update = true
                this.company.user_id = this.$route.params.user_id
                console.log(this.company)
                apiCompanies.store({
                    user_id: this.company.user_id,
                    name: this.company.name,
                    logo: this.company.logo,
                    email: this.company.email,
                    street: this.company.street,
                    city: this.company.city,
                    state: this.company.state,
                    zip: this.company.zip,
                    phone: this.company.phone
                }).then(response => {
                        this.$notify({
                            type: 'info',
                            title: response.data.message
                        })
                        this.pending.update = false
                        console.log(response.data.user)
                        this.$router.push('/')
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        },
        computed: {
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>
