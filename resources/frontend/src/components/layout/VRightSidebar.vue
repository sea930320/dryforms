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
        background-color: #0d1722;
    }
    .list-group-item {
        background-color: #046ac3;
        margin-bottom: 3px;
        border-radius: unset;
    }
</style>