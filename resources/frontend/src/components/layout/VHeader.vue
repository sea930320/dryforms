<template>
    <b-navbar toggleable="md" type="light" variant="light">
        <b-navbar-brand href="#">DryForms</b-navbar-brand>
        <b-navbar-nav>
            <b-nav-item v-for="item in menuItems" :key="item.route" v-if="$session.get('apiToken')">
                 <router-link :to="item.route" class="pointer">{{ item.name }}</router-link>
            </b-nav-item>
        </b-navbar-nav>

        <b-navbar-nav class="ml-auto">
            <b-nav-item v-if="!$session.get('apiToken')"><router-link to="/login">Login</router-link></b-nav-item>
            <b-nav-item v-if="!$session.get('apiToken')"><router-link to="/register">Register</router-link></b-nav-item>
            <b-nav-item v-if="$session.get('apiToken')" v-on:click="logout()"><i class="fa fa-sign-out"></i> Logout</b-nav-item>
        </b-navbar-nav>
    </b-navbar>
</template>

<script type="text/babel">
    import authorization from '../../mixins/authorization'

    export default {
        mixins: [authorization],
        data() {
            return {
                menuItems: [
                    {
                        name: 'Projects',
                        route: '/projects'
                    },
                    {
                        name: 'Settings',
                        route: '/settings/account'
                    },
                    {
                        name: 'Standards',
                        route: '/standards'
                    },
                    {
                        name: 'Equipment',
                        route: '/equipment'
                    },
                    {
                        name: 'Training',
                        route: '/training'
                    }
                ]
            }
        },
        methods: {}
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">

</style>