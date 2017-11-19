<template>
    <b-container fluid id="app">
        <v-header :sideBarOpened.sync="sideBarOpened"/>
        <b-row>
        <v-left-sidebar :collapsed.sync="sideBarCollapsed" class="col-md-2"/>

        <div class="col-md-8">

            <section role="main" class="content">
                <router-view></router-view>
            </section>

        </div>
        <v-right-sidebar :collapsed.sync="sideBarCollapsed" class="col-md-2"/>
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
                sideBarCollapsed: false
            }
        },
        components: {VHeader, VLeftSidebar, VRightSidebar},
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
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    @import 'bootstrap-vue/dist/bootstrap-vue.css';
    #app {
        padding-left: 0;
        padding-right: 0;
        overflow-x: hidden;
    }
    nav {
        margin-bottom: 20px;
    }
</style>