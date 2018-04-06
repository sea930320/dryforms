<template>
    <b-list-group class="text-left p-0" v-if='isLoaded'>
        <template v-if="isStandards === true">
            <b-list-group-item class="bg-blue mb-2 list-complete-item">
                <router-link :to="{name: 'Forms Order'}" class="pointer text-white">
                    <div class="m-0"><img v-if="leftLinksIcon['Forms Order'] != ''" :src="leftLinksIcon['Forms Order']"> Forms Order</div>
                </router-link>
            </b-list-group-item>
            <b-list-group-item v-for="link in formsOrder" :key="link.id" class="list-complete-item" :class="link.mb ? 'bg-blue mb-2' : 'bg-grey'" v-if="link.default_statements.length > 0 || link.form.name==='Project Scope'">
                <router-link v-if="link.form.name !== 'Project Scope'" :to="{name: 'Standards Form', params: {form_id: link.form_id}}" :class="link.mb ? 'pointer text-white' : 'pointer text-black'">
                    <div class="m-0">
                        <img v-if="leftLinksIcon[link.form.name] != ''" :src="leftLinksIcon[link.form.name]" class="left-sidebar-img">
                        <input type="text" v-model="link.standard_form[0].name" class="leftLinkInput" @input="updateFormName(link.standard_form[0])">
                    </div>
                </router-link>
                <router-link v-else :to="{name: 'Project Scope'}" class="pointer text-black">
                    <div class="m-0">
                        <img v-if="leftLinksIcon['Project Scope'] != ''" :src="leftLinksIcon['Project Scope']" class="left-sidebar-img">
                         <input type="text" v-model="link.standard_form[0].name" class="leftLinkInput" @input="updateFormName(link.standard_form[0])">
                    </div>
                </router-link>
            </b-list-group-item>
        </template>
        <template v-else-if="isForms === true">
            <b-list-group-item class="bg-blue mb-2 list-complete-item">
                <router-link :to="{name: 'Forms'}" class="pointer text-white">
                    <div class="m-0"><img v-if="leftLinksIcon['Forms'] != ''" :src="leftLinksIcon['Forms']"> Forms </div>
                </router-link>
            </b-list-group-item>
            <b-list-group-item v-for="link in formsOrder" :key="link.id" class="list-complete-item" :class="link.mb ? 'bg-blue mb-2' : 'bg-grey'" v-if="link.form_id !== 12 && (link.selected === '1' || (projectSelectedForms && projectSelectedForms[link.form_id]))">
                <router-link :to="{name: 'Form ' + link.form.name, params: {project_id: projectId, form_id: link.form_id}}" :class="link.mb ? 'pointer text-white' : 'pointer text-black'">
                    <div class="m-0">
                        <img v-if="leftLinksIcon[link.form.name] != ''" :src="leftLinksIcon[link.form.name]" class="left-sidebar-img">
                        <span class="left-sidebar-ellipse" :class="icon-margin"> {{ link.standard_form[0].name }} </span>
                    </div>
                </router-link>
            </b-list-group-item>
        </template>
        <b-list-group-item v-for="link in leftLinks" :key="link.name" :class="link.mb ? 'bg-blue mb-2' : 'bg-grey'">
            <router-link :to="link.path" :class="link.mb ? 'pointer text-white' : 'pointer text-black'">
                <div class="m-0">
                    <div class="left-sidebar-img" v-if="link.icon != ''"><img :src="link.icon"/></div>
                    <span class="left-sidebar-ellipse" :class="link.icon ? 'icon-margin' : ''"> {{ link.name }} </span>
                </div>
            </router-link>
        </b-list-group-item>
    </b-list-group>
    <loading v-else></loading>
</template>

<script type="text/babel">
    import {mapActions} from 'vuex'
    import Loading from './Loading'
    import apiStandardForm from '../../api/standard_form'
    import apiProjectForms from '../../api/project_forms'

    import _ from 'lodash'
    import ErrorHandler from '../../mixins/error-handler'

    export default {
        mixins: [ErrorHandler],
        components: {
          Loading
        },
        computed: {
            formsOrder: function() {
                return this.$store.state.StandardForm.formsOrder
            },
            isLoaded: function() {
                return this.isStandards === false || (this.isStandards === true && this.formsOrder.length !== 0)
            }
        },
        created() {
            this.leftLinksIcon = this.$config.get('leftLinksIcon')
            this.leftLinks = this.$route.meta.leftLinks
            if (this.$route.path.indexOf('standards') !== -1) {
                this.isStandards = true
                this.fetchFormsOrder()
            } else {
                this.isStandards = false
            }

            if (this.$route.path.indexOf('forms') !== -1) {
                this.isForms = true
            } else {
                this.isForms = false
            }
        },
        data() {
            return {
                leftLinks: [],
                isStandards: null,
                isForms: null,
                leftLinksIcon: {},
                projectSelectedForms: null,
                projectId: null
            }
        },
        methods: {
            ...mapActions([
                'fetchFormsOrder'
            ]),
            updateFormName: _.debounce(function (standardForm) {
                if (standardForm.id) {
                    apiStandardForm.patch(standardForm.id, {
                        id: standardForm.id,
                        name: standardForm.name
                    }).then(response => {
                    }).catch(this.handleErrorResponse)
                } else {
                    apiStandardForm.store(standardForm)
                    .then(response => {
                        standardForm.id = response.data.form.id
                    }).catch(this.handleErrorResponse)
                }
            }, 500)
        },
        watch: {
            '$route' (to, from) {
                this.leftLinks = to.meta.leftLinks
                if (to.path.indexOf('standards') !== -1) {
                    this.isStandards = true
                    this.fetchFormsOrder()
                } else {
                    this.isStandards = false
                }
                if (to.path.indexOf('forms') !== -1) {
                    this.isForms = true
                    this.fetchFormsOrder()
                    this.projectId = to.params.project_id
                    apiProjectForms.index({
                        project_id: this.projectId
                    }).then((response) => {
                        let projectForms = response.data
                        this.$store.state.ProjectForm.projectForms = projectForms
                        this.$store.state.ProjectForm.projectId = this.projectId
                        this.projectSelectedForms = []
                        projectForms.forEach(projectForm => {
                            this.projectSelectedForms[projectForm.form_id] = true
                        })
                    })
                } else {
                    this.isForms = false
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
        margin-bottom: 3px;
        border-radius: unset;
        padding: 0.75rem 0.75rem;
    }
    .bg-blue {
        background-color: #046ac3;
    }
    .bg-grey {
        background-color: #c8c8c8;
    }
    .bg-side-left {
        background-color: rgba(187, 187, 187, 0.2);
        border-radius: 50px;
        box-shadow: inset 0px 0px 20px 2px rgba(230, 219, 219, 0.18), 0px 0px 0px 0px rgba(228, 219, 219, 0.15);
        margin: 15px 15px 0px 15px;
        border: 0px;
    }
    .text-black {
        color: black;
    }

    .leftLinkInput {
        text-align: left;
        background-color: transparent;
        border: none;
        width: calc(100% - 39px);
        float: left;
        margin-left: 7px;
        cursor: pointer;
    }
</style>