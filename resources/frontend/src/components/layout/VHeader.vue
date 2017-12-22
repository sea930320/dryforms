<template>
    <b-navbar toggleable="md" class="p-0 m-0">
        <b-navbar-brand href="#" class="pl-5 pr-5 m-0">
            <img :src="logoImg" alt="Logo">
        </b-navbar-brand>
        <b-navbar-nav class="left-nav">
            <b-nav-item v-for="item in menuItems" :key="item.route" v-if="$session.get('apiToken')">
                <router-link :to="item.route" class="pointer text-center">
                    <p class="mb-0"><img :src="item.img" alt="Logo"></p>
                    <p class="text-white font-weight-bold text-uppercase mb-0">{{ item.name }}</p>
                </router-link>
            </b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav class="right-nav ml-auto">
            <b-nav-item v-if="!$session.get('apiToken')"><router-link to="/login">Login</router-link></b-nav-item>
            <b-nav-item v-if="!$session.get('apiToken')"><router-link to="/register">Register</router-link></b-nav-item>
            <b-nav-item v-if="$session.get('apiToken')" class="dashboard text-center pt-3">
                <a href="/admin"><img :src="dashbordImg"></a>
            </b-nav-item>
            <b-nav-item v-if="$session.get('apiToken')" v-on:click="logout()" class="logout">
                <div class="text-right version">Version 1.00</div>
                <div class="text-uppercase font-weight-bold logout-link">Logout <i class="fa fa-sign-out"></i></div>
            </b-nav-item>
        </b-navbar-nav>
    </b-navbar>
</template>

<script type="text/babel">
    import authorization from '../../mixins/authorization'

    export default {
        mixins: [authorization],
        data() {
            return {
                logoImg: require('../../assets/logo.png'),
                dashbordImg: require('../../assets/dashboard.png'),
                menuItems: [
                    {
                        name: 'Projects',
                        route: '/projects',
                        img: require('../../assets/nav-project.png')
                    },
                    {
                        name: 'Settings',
                        route: '/settings/account',
                        img: require('../../assets/nav-setting.png')
                    },
                    {
                        name: 'Standards',
                        route: '/standards',
                        img: require('../../assets/nav-standard.png')
                    },
                    {
                        name: 'Equipment',
                        route: '/equipment',
                        img: require('../../assets/nav-inventory.png')
                    },
                    {
                        name: 'Training',
                        route: '/training',
                        img: require('../../assets/nav-training.png')
                    }
                ]
            }
        },
        methods: {}
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .navbar {
        background-color: #515763;
        .navbar-brand {
            background-color: #0d1722;
            padding-top: 23px;
            padding-bottom: 23px;
        }
        .left-nav {
            .nav-item {
                width: 120px;
                border-left: 1px solid #898c93;
                &:hover {
                    background: linear-gradient(rgba(255, 255, 255, 0), rgba(17, 103, 179, 1));
                }
            }
        }
        .right-nav {
            .dashboard {
                width: 87px;
                background-color: #046ac3;
            }
            .logout {
                width: 265px;
                .nav-link {
                    color: white;
                    padding: 0;
                }
                .version {
                    background-color: #4a4c52;
                }
                .logout-link {
                    height: 63px;
                    padding-top: 16px;
                    padding-left: 20px;
                    font-size: 20px;
                }
            }
        }
    }
</style>