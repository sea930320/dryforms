<template>
    <b-list-group class="text-center">
        <b-list-group-item v-for="link in $route.meta.rightLinks" :key="link.name" :class="link.mt ? 'mt-2': ''"  v-if="!isFormOrder || !isHiddenMenu(link.name)">
            <router-link v-if="link.path" :to="link.path" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0 right-sidebar-ellipse icon-margin' : 'text-uppercase float-left m-0 right-sidebar-ellipse icon-margin'">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right">
            </router-link>
            <div v-else-if="link.methodCall" class="pointer text-white text-center" @click="methodCall(link.methodCall)">
                <p class="text-uppercase float-left m-0 right-sidebar-ellipse icon-margin">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right">
            </div>
        </b-list-group-item>
    </b-list-group>
</template>
<script type="text/babel">
    export default {
        data() {
            return {
                isFormOrder: false,
                formOrderHiddenMenu: ['Save', 'Add Statement']
            }
        },
        methods: {
            isHiddenMenu(menuName) {
                return (this.formOrderHiddenMenu.indexOf(menuName) > -1)
            }
        },
        watch: {
            '$route' (to, from) {
                if (to.path.indexOf('standards/formorder') !== -1) {
                    this.isFormOrder = true
                } else {
                    this.isFormOrder = false
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    .list-group {
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.3);
    }
    .list-group-item {
        background-color: rgba(187, 187, 187, 0.2);
        border-radius: 50px;
        box-shadow: inset 0px 0px 20px 2px rgba(230, 219, 219, 0.18), 0px 0px 0px 0px rgba(228, 219, 219, 0.15);
        margin: 15px 15px 0px 15px;
        border: 0px;
        padding: 0.5rem 1.25rem;
    }
</style>