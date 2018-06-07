<template>
    <div class="projects-scope">
        <div class="card" v-if="isLoaded">
            <div class="card-body text-center">
                <form-header></form-header>
                <h4 class="mb-2">{{ $route.meta.title }}</h4>
                <div class="dropdown-divider"></div>
                <form-banner></form-banner>            
                <div v-for="(area_index) in _.range(curAreaNum)" :key="area_index.id">
                    <div class="bg-grey p-1">
                        <h5 class="m-0"> {{projectAreas[area_index].standard_area.title}} </h5>
                    </div>
                    <scope-list class="mt-1 mb-5"
                        :projectAreaID="projectAreas[area_index].id"
                        :projectID="project_id"
                        :uoms="uoms"
                        isMisc=0
                    ></scope-list>
                </div>
                <infinite-loading @infinite="infiniteHandler" ref="infiniteLoading">
                    <div slot="no-more">
                    </div>
                </infinite-loading>
                <scope-list class="mt-1 mb-5"
                    :projectID="project_id"
                    :uoms="uoms"
                    :miscScopes="miscScopes"
                    isMisc=1
                ></scope-list>
                <footer-text class="mt-0"></footer-text>
            </div>        
        </div>
        <loading v-else></loading>
    </div>
</template>

<script type="text/babel">
    import FormHeader from './FormHeader'
    import FormBanner from './FormBanner'
    import ScopeList from './ScopeList'
    import FooterText from './FooterText'
    import apiProjectAreas from '../../api/project_areas'
    import apiProjectScope from '../../api/project_scope'
    import apiUom from '../../api/uom'
    import ErrorHandler from '../../mixins/error-handler'
    import Loading from '../layout/Loading'
    import InfiniteLoading from 'vue-infinite-loading'

    export default {
        mixins: [ErrorHandler],
        components: {FormHeader, FormBanner, ScopeList, Loading, InfiniteLoading, FooterText},
        data() {
            return {
                projectAreas: [],
                curAreaNum: 0,
                projectScopes: [],
                miscScopes: [],
                project_id: null,
                isLoaded: false,
                uoms: []
            }
        },
        created() {
            this.init()
        },
        methods: {
            init: function() {
                this.project_id = this.$route.params.project_id
                const apis = [
                    apiProjectAreas.index({
                        project_id: this.project_id
                    }),
                    apiUom.index(),
                    apiProjectScope.index({
                        project_id: this.project_id,
                        curPageNum: 0
                    })
                ]
                Promise.all(apis)
                .then(res => {
                    this.projectAreas = res[0].data.project_areas
                    if (this.projectAreas.length === 0) {
                        this.$router.push({
                            name: 'Form Affected Areas',
                            params: {
                                project_id: this.project_id,
                                form_id: 12
                            }
                        })
                        return
                    }
                    let uoms = res[1].data.uoms
                    this.miscScopes = res[2].data.misc_page_scopes
                    this.uoms = ['----']
                    uoms.forEach((uom) => {
                        this.uoms[uom.id] = uom.title
                    })
                    this.isLoaded = true
                }).catch(this.handleErrorResponse)
            },
            infiniteHandler($state) {
                this.fetchNextPageScopes()
            },
            fetchNextPageScopes() {
                this.curAreaNum++
                if (this.curAreaNum > this.projectAreas.length - 1) {
                    this.curAreaNum = this.projectAreas.length
                    this.$refs.infiniteLoading.$emit('$InfiniteLoading:complete')
                } else {
                    this.$refs.infiniteLoading.$emit('$InfiniteLoading:loaded')
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 3px;
    }

    table {
        width: 100%;
        input {
            text-align: center;
            width: 100%;
            background-color: transparent;
            border: none;
        }
    }

    .w-50 {
        width: 50%;
    }

    .bg-grey {
        background-color: #c3c3c3;
    }

    .projects-scope .infinite-status-prompt {
        display: none
    }
</style>