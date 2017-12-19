<template>
    <b-list-group class="text-left p-0">
        <b-list-group-item v-for="link in $route.meta.leftLinks" :key="link.name" :class="link.mb ? 'bg-blue mb-2' : 'bg-grey'">
            <router-link :to="link.path" :class="link.mb ? 'pointer text-white' : 'pointer text-black'">
                <p class="m-0"><img v-if="link.icon != ''" :src="link.icon"> {{ link.name }}</p>
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
        max-width: 279px;
    }
    .list-group-item {
        margin-bottom: 3px;
    }
    .bg-blue {
        background-color: #046ac3;
    }
    .bg-grey {
        background-color: #c8c8c8;
    }
    .text-black {
        color: black;
    }
</style>