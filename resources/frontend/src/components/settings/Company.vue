<template>
    <div class="card text-center">
        <div class="card-header">
            {{ $route.meta.title }}
        </div>
        <div class="card-body text-left">
            <form>
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label>Upload your Company Logo:</label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Company Name:</label>
                            <input type="text" class="form-control" v-model="company.name">
                        </div>
                        <div class="form-group">
                            <label>Street Address:</label>
                            <input type="text" class="form-control" v-model="company.address">
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
                            <input type="text" class="form-control" v-model="company.cloudLink">
                        </div>
                    </div>
                </div>

                <button class="btn btn-sm btn-primary" v-on:click="">Submit</button>
            </form>
        </div>
        <div class="card-footer text-muted">
        </div>
    </div>
</template>

<script type="text/babel">
    export default {
        name: 'Company',
        data() {
            return {
                company: {
                    name: null,
                    address: null,
                    city: null,
                    state: null,
                    zip: null,
                    phone: null,
                    email: null,
                    cloudLink: null
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
</style>