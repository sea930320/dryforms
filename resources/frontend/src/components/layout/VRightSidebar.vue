<template>
    <div class="right_menu_group text-center">
        <div v-for="link in $route.meta.rightLinks" :key="link.name">
            <div v-if="link.name == 'Print'" class="right-menu-item" :class="link.mt ? 'mt-2': ''">
            <router-link :to="{name: 'Print', params: {project_id: projectId}}" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0 right-sidebar-ellipse icon-margin' : 'text-uppercase float-left m-0 right-sidebar-ellipse icon-margin'" class="right-menu-text">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right right-menu-icon">
            </router-link>
            </div>
            <div v-else-if="link.name == 'Preview'" class="right-menu-item" :class="link.mt ? 'mt-2': ''">
            <div @click="preview()" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0 right-sidebar-ellipse icon-margin' : 'text-uppercase float-left m-0 right-sidebar-ellipse icon-margin'" class="right-menu-text">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right right-menu-icon">
            </div>
            </div>
            <div v-else-if="link.name == 'Email'" class="right-menu-item" :class="link.mt ? 'mt-2': ''">
            <router-link :to="{name: 'Email', params: {project_id: projectId}}" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0 right-sidebar-ellipse icon-margin' : 'text-uppercase float-left m-0 right-sidebar-ellipse icon-margin'" class="right-menu-text">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right right-menu-icon">
            </router-link>
            </div>
            <div v-else-if="link.path" class="right-menu-item" :class="link.mt ? 'mt-2': ''">
            <router-link :to="link.path" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0 right-sidebar-ellipse icon-margin' : 'text-uppercase float-left m-0 right-sidebar-ellipse icon-margin'" class="right-menu-text">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right right-menu-icon">
            </router-link>
            </div>
            <div v-if="link.form_id == 12" class="right-menu-item" :class="link.mt ? 'mt-2': ''">
            <router-link :to="{name: 'Form Affected Areas', params: {project_id: projectId, form_id: link.form_id}}" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0 right-sidebar-ellipse icon-margin' : 'text-uppercase float-left m-0 right-sidebar-ellipse icon-margin'" class="right-menu-text">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right right-menu-icon">
            </router-link>
            </div>
            <div v-else-if="(formId == 7 || formId == 8) && link.form_id == 13" class="right-menu-item" :class="link.mt ? 'mt-2': ''">
            <router-link :to="{name: 'Form Add Days', params: {project_id: projectId, form_id: link.form_id, prev_id: formId}}" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0 right-sidebar-ellipse icon-margin' : 'text-uppercase float-left m-0 right-sidebar-ellipse icon-margin'" class="right-menu-text">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right right-menu-icon">
            </router-link>
            </div>
            <div v-else-if=" formId == 6 && link.form_id == 14" class="right-menu-item" :class="link.mt ? 'mt-2': ''">
            <router-link :to="{name: 'Form Equipment Manager', params: {project_id: projectId, form_id: link.form_id}}" class="pointer text-white text-center">
                <p :class="link.mt ? 'text-uppercase m-0 right-sidebar-ellipse icon-margin' : 'text-uppercase float-left m-0 right-sidebar-ellipse icon-margin'" class="right-menu-text">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right right-menu-icon">
            </router-link>
            </div>
            <div v-if="link.methodCall" class="right-menu-itemm" :class="link.mt ? 'mt-2': ''">
            <div class="pointer text-white text-center" @click="methodCall(link.methodCall)">
                <p class="text-uppercase float-left m-0 right-sidebar-ellipse icon-margin right-menu-text">{{ link.name }}</p>
                <img v-if="link.icon != ''" :src="link.icon" class="float-right right-menu-icon">
            </div>
            </div>
        </div>
    </div>
</template>
<script type="text/babel">
    export default {
        data() {
            return {
                isFormOrder: false,
                formOrderHiddenMenu: ['Save', 'Add Statement'],
                isForms: null,
                projectId: null,
                formId: null
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
            },
            preview(flag) {
                window.location.href = '/project/print/' + this.projectId
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
                    this.formId = to.params.form_id
                }
            }
        }
    }
</script>

<style>
    .right_menu_group {
        height: 100vh;
        background-color: #0d1722;
    }
    .right-menu-item {
        background-color: #046ac3;
        margin-bottom: 3px;
        height: 50px;
        border-radius: unset;
    }
    .right-menu-text {
        padding-left: 21.5px;
        padding-top: 11.5px;
        width: 160px;
    }
    .right-menu-icon {
        padding-top: 11.5px;
        padding-right: 25px;
    }
</style>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
</style>