<template>
    <b-navbar toggleable="md" type="light" variant="light">
        <b-navbar-brand href="#">DryForms</b-navbar-brand>
        <b-navbar-nav>
            <b-nav-item v-for="item in menuItems" :href="item.route" :key="item.route">{{ item.name }}</b-nav-item>
        </b-navbar-nav>

        <b-navbar-nav class="ml-auto">
            <b-nav-item><router-link to="/login">Login</router-link></b-nav-item>
            <b-nav-item>Register</b-nav-item>
            <b-nav-item><i class="fa fa-sign-out"></i> Logout</b-nav-item>
        </b-navbar-nav>
    </b-navbar>
</template>
<script type="text/babel">
    export default {
        data() {
            return {
                menuItems: [
                    {
                        name: 'Projects',
                        route: '/projects'
                    },
                    {
                        name: 'Settings',
                        route: '/settings'
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
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">

</style>