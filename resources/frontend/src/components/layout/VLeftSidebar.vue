<template>
    <b-list-group class="text-center">
        <b-list-group-item v-for="link in $route.meta.leftLinks" :key="link.name">
            <router-link :to="link.path" class="pointer">{{ link.name }}</router-link>
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

<style type="text/css" lang="scss" rel="stylesheet/scss">

</style>