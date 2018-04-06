<template>
    <b-list-group class="text-center">
        <b-list-group-item v-for="link in $route.meta.rightLinks" :key="link.name" :class="link.mt ? 'mt-2': ''">
            <router-link v-if="link.path" :to="link.path" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0 right-sidebar-ellipse icon-margin' : 'text-uppercase float-left m-0 right-sidebar-ellipse icon-margin'">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right">
            </router-link>
            <router-link v-if="link.form_id" :to="{name: 'Form Affected Areas', params: {project_id: projectId, form_id: link.form_id}}" class="pointer text-white text-center">
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
                formOrderHiddenMenu: ['Save', 'Add Statement'],
                isForms: null,
                projectId: null
            }
        },
        created() {
        },
        methods: {
            methodCall(mth) {
                return this[mth.section](mth.name)
            },
            standards(name) {
                if (name === 'add_statement') {
                    this.$bus.$emit('standards_add_statement')
                } else if (name === 'save') {
                    this.$bus.$emit('standards_save')
                }
            },
            forms(name, action) {
                if (name === 'save') {
                    let routeName = this.$route.name
                    this.$bus.$emit('forms_save', routeName)
                }
            }
        },
        watch: {
            '$route' (to, from) {
                if (to.path.indexOf('standards/formorder') !== -1) {
                    this.isFormOrder = true
                } else {
                    this.isFormOrder = false
                }
                if (to.path.indexOf('forms') !== -1) {
                    this.projectId = to.params.project_id
                }
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