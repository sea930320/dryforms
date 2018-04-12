<template>
    <b-row>
        <b-col class="text-left">
            <img v-if="company.logo" :src="logoRootPath + 'settings/logo/' + company.logo" alt="Company Logo" height="90">
            <img v-else :src="companyLogo" alt="Company Logo" height="90">
        </b-col>
        <b-col class="text-right">
            <h5 class="m-0">{{ company.name ? company.name : '' }}</h5>
            <p class="m-0">{{ company.street ? company.street : '' }}</p>
            <p class="m-0">{{ company.city ? company.city : '' }} {{ company.state ? company.state : '' }} {{ company.zip ? company.zip : '' }}</p>
            <p class="m-0">{{ company.phone ? company.phone : '' }}</p>
            <p class="m-0">{{ company.email ? company.email : '' }}</p>
        </b-col>
    </b-row>
</template>

<script type="text/babel">
    import { mapActions } from 'vuex'

    export default {
        name: 'form-header',
        data() {
            return {
                companyLogo: require('../../assets/fallback-logo.jpg'),
                title: 'Flood out',
                street: '8631 Rocky Ave',
                city: 'Las Vegas',
                state: 'Nevada',
                zipcode: '89143',
                phone: '702-591-8889',
                email: 'readyfloodrestoration@gmail.com'
            }
        },
        created() {
            this.fetchUser()
        },
        computed: {
          company: function() {
              return this.$store.state.User.company
          }
        },
        methods: {
            ...mapActions([
                'fetchUser'
            ])
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
</style>