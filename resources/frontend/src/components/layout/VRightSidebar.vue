<template>
    <b-list-group class="text-center">
        <b-list-group-item v-for="link in $route.meta.rightLinks" :key="link.name" :class="link.mt ? 'mt-2': ''">
            <router-link :to="link.path" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0' : 'text-uppercase float-left m-0'">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right">
            </router-link>
        </b-list-group-item>
    </b-list-group>
</template>
<script type="text/babel">
    export default {
        data() {
            return {
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
        // background-color: #046ac3;
        // margin-bottom: 3px;
        // border-radius: unset;
        background-color: rgba(187, 187, 187, 0.2);
        border-radius: 50px;
        box-shadow: inset 0px 0px 20px 2px rgba(230, 219, 219, 0.18), 0px 0px 0px 0px rgba(228, 219, 219, 0.15);
        margin: 15px 15px 0px 15px;
        border: 0px;
        padding: 0.5rem 1.25rem;
    }
</style>