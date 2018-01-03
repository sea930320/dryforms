<template>
    <b-container fluid id="app">
        <v-header :sideBarOpened.sync="sideBarOpened"/>

        <b-row v-if="!isSignView">
            <v-left-sidebar :collapsed.sync="sideBarCollapsed" class="col-md-2"/>
            <div class="col-md-8 p-0">
                <section role="main" class="content">
                    <notifications position="top center"/>
                    <router-view></router-view>
                </section>
            </div>
            <v-right-sidebar :collapsed.sync="sideBarCollapsed" class="col-md-2"/>
        </b-row>

        <b-row v-else align-h="center" class="sign-view m-0 pt-5">
            <div class="col-8">
                <notifications position="top center"/>
                <router-view></router-view>
            </div>
        </b-row>
    </b-container>
</template>

<script type="text/babel">
    import VHeader from './VHeader'
    import VLeftSidebar from './VLeftSidebar'
    import VRightSidebar from './VRightSidebar'

    export default {
        data() {
            return {
                sideBarOpened: false,
                sideBarCollapsed: true,
                sideBarHidden: true,
                isLoaded: false,
                isSignView: false
            }
        },
        components: {VHeader, VLeftSidebar, VRightSidebar},
        created () {
            this.isSignView = this.beforeSign()
        },
        computed: {
            bodyClass() {
                let bodyClass = []
                if (this.sideBarCollapsed) {
                    bodyClass.push('sidebar-left-collapsed')
                }
                if (this.sideBarOpened) {
                    bodyClass.push('sidebar-left-opened')
                }
                return bodyClass
            }
        },
        watch: {
            '$route' (to, from) {
                this.isSignView = this.beforeSign()
            }
        },
        methods: {
            beforeSign () {
                if (this.$route.name === 'Login' || this.$route.name === 'Register') {
                    return true
                } else {
                    return false
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    $break-extra: 1200px;

    body {
        overflow: hidden;
        position: relative;
        @media screen and (max-width: $break-extra) {
            font-size: 14px;
        }
    }
    #app {
        padding-left: 0;
        padding-right: 0;
    }
    .btn-xs {
        font-size: 11px;
        padding: 2px;
        padding-left: 8px;
        padding-right: 8px;
    }
    .content {
        display: block;
        width: 100%;
        height: 90%;
        overflow-y: scroll;
        position: absolute;
    }
    .sign-view {
        height: 90vh;
        overflow-y: scroll;
    }
</style>