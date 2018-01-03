<template>
    <div>
        <div class="card text-center" v-if="isLoaded">
            <div class="card-header">
                <h5>{{ $route.meta.title }}</h5>
            </div>
            <div class="card-body text-left">
                <form>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <img :src="company.imageUrl" height="120" v-if="company.imageUrl">
                            </div>
                            <div class="form-group">
                                <label>Upload your Company Logo:</label>
                                <input type="file" class="form-control" ref="image" accept="image/*" @change="onFilePicked">
                            </div>
                            <div class="form-group">
                                <label>Company Name:</label>
                                <input type="text" class="form-control" v-model="company.name">
                            </div>
                            <div class="form-group">
                                <label>Street Address:</label>
                                <input type="text" class="form-control" v-model="company.street">
                            </div>
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" class="form-control" v-model="company.city">
                            </div>
                            <div class="form-group">
                                <label>State:</label>
                                <input type="text" class="form-control" v-model="company.state">
                            </div>
                            <div class="form-group">
                                <label>Zip Code:</label>
                                <input type="text" class="form-control" v-model="company.zip">
                            </div>
                            <div class="form-group">
                                <label>Phone:</label>
                                <input type="text" class="form-control" v-model="company.phone">
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="text" class="form-control" v-model="company.email">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <br>
                                <button class="btn btn-primary" v-on:click="">Update Credit Card Info</button>
                            </div>
                            <div class="form-group">
                                <label>Cloud Link:</label>
                                <input type="text" class="form-control" v-model="company.cloud_link">
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-sm btn-primary" @click="update">Submit</button>
                </form>
            </div>
            <div class="card-footer text-muted">
            </div>
        </div>
        <loading v-else></loading>
    </div>    
</template>

<script type="text/babel">
    import Loading from '../layout/Loading'
    import apiCompanies from '../../api/companies'

    export default {
        name: 'Company',
        components: {Loading},
        data() {
            return {
                isLoaded: false,
                company: {
                    name: null,
                    street: null,
                    city: null,
                    state: null,
                    zip: null,
                    phone: null,
                    email: null,
                    cloud_link: null,
                    imageName: '',
                    imageUrl: '',
                    imageFile: ''
                }
            }
        },
        created() {
            this.initData()
        },
        methods: {
            update() {
                console.log(this.company)
                apiCompanies.patch(1, this.company)
                    .then(response => {
                        this.company = response.data.company
                        this.$notify({
                            type: 'info',
                            title: response.data.message
                        })
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            initData() {
                apiCompanies.show(1)
                    .then(response => {
                        this.company = response.data
                        this.isLoaded = true
                    })
                    .catch(error => {
                        console.log(error.response)
                    })
            },
            onFilePicked (e) {
                const files = e.target.files
                if (files[0] !== undefined) {
                    this.company.imageName = files[0].name
                    if (this.company.imageName.lastIndexOf('.') <= 0) {
                    return
                    }
                    const fr = new FileReader()
                    fr.readAsDataURL(files[0])
                    fr.addEventListener('load', () => {
                        this.company.imageUrl = fr.result
                        this.company.imageFile = files[0]
                    })
                } else {
                    this.company.imageName = ''
                    this.company.imageFile = ''
                    this.company.imageUrl = ''
                }
          }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>