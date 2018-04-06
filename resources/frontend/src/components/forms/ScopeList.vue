<template>
    <div>
        <div v-if="isLoaded">
            <template v-if="isMisc==='0'">
                <b-row v-for="(page_index) in _.range(curPageNum)" :key="page_index">
                    <div class="col-md-12">
                        <b-row align-h="end">
                            <b-col cols="2" class="text-center" style="font-size:14px; color: black;">
                                Page: {{page_index + 1}} &nbsp;&nbsp;
                                <hr class="mt-0">
                            </b-col>
                        </b-row>
                    </div>
                    <b-list-group class="col-md-6 pr-3 scope-list-group">
                        <b-list-group-item v-for="(scope, index) in leftProjectScopes[page_index]" :key="index" class='p-0'>
                            <b-row v-if="scope.standard_scope_edited" class="m-0 disable-edit">
                                <div v-if="scope.is_header" class="bg-grey w-selected">X</div>
                                <div v-else class="w-selected">
                                    <i class="fa fa-check" v-if="scope.selected" aria-hidden="true"></i>
                                </div>
                                <div :class="scope.is_header ? 'bg-grey w-service': 'w-service'">{{scope.service}}</div>
                                <div v-if="scope.is_header" class="bg-grey w-uom">UOM</div>
                                <div v-else class="w-uom">
                                    {{scope.uom_info ? scope.uom_info.title: ''}}
                                </div>
                                <div v-if="scope.is_header" class="bg-grey w-qty">QTY</div>
                                <div v-else class="w-qty">
                                    {{scope.qty}}
                                </div>
                            </b-row>
                            <b-row v-else class="m-0">
                                <div v-if="scope.is_header" class="bg-grey w-selected">X</div>
                                <div v-else class="w-selected">
                                    <b-form-checkbox v-model="scope.selected" value="1" unchecked-value="0" @change="updateScope(scope)"></b-form-checkbox>
                                </div>
                                <div :class="scope.is_header ? 'bg-grey w-service': 'w-service'">
                                    <b-form-input v-model="scope.service" @input="updateScope(scope)"></b-form-input>
                                </div>
                                <div v-if="scope.is_header" class="bg-grey w-uom">UOM</div>
                                <div v-else class="w-uom">
                                    <select v-model='scope.uom' class='form-control header-uom pt-0 pb-0' @change="updateScope(scope)">
                                        <option v-for='(title,index) in uoms' :key='index' :value='index'> {{title}}</option>
                                    </select>
                                </div>
                                <div v-if="scope.is_header" class="bg-grey w-qty">QTY</div>
                                <div v-else class="w-qty">
                                    <b-form-input v-model="scope.qty" @input="updateScope(scope)"></b-form-input>
                                </div>
                            </b-row>
                        </b-list-group-item>
                    </b-list-group>
                    <b-list-group class="col-md-6 pl-3 scope-list-group">
                        <b-list-group-item v-for="(scope, index) in rightProjectScopes[page_index]" :key="index" class='p-0'>
                            <b-row v-if="scope.standard_scope_edited" class="m-0 disable-edit">
                                <div v-if="scope.is_header" class="bg-grey w-selected">X</div>
                                <div v-else class="w-selected">
                                    <i class="fa fa-check" v-if="scope.selected" aria-hidden="true"></i>
                                </div>

                                <div :class="scope.is_header ? 'bg-grey w-service': 'w-service'">{{scope.service}}</div>

                                <div v-if="scope.is_header" class="bg-grey w-uom">UOM</div>
                                <div v-else class="w-uom">
                                    {{scope.uom_info ? scope.uom_info.title: ''}}
                                </div>

                                <div v-if="scope.is_header" class="bg-grey w-qty">QTY</div>
                                <div v-else class="w-qty">
                                    {{scope.qty}}
                                </div>
                            </b-row>
                            <b-row v-else class="m-0">
                                <div v-if="scope.is_header" class="bg-grey w-selected">X</div>
                                <div v-else class="w-selected">
                                    <b-form-checkbox v-model="scope.selected" value="1" unchecked-value="0" @change="updateScope(scope)"></b-form-checkbox>
                                </div>
                                <div :class="scope.is_header ? 'bg-grey w-service': 'w-service'">
                                    <b-form-input v-model="scope.service" @input="updateScope(scope)"></b-form-input>
                                </div>
                                <div v-if="scope.is_header" class="bg-grey w-uom">UOM</div>
                                <div v-else class="w-uom">
                                    <select v-model='scope.uom' class='form-control header-uom pt-0 pb-0' @change="updateScope(scope)">
                                        <option v-for='(title,index) in uoms' :key='index' :value='index'> {{title}}</option>
                                    </select>
                                </div>
                                <div v-if="scope.is_header" class="bg-grey w-qty">QTY</div>
                                <div v-else class="w-qty">
                                    <b-form-input v-model="scope.qty" @input="updateScope(scope)"></b-form-input>
                                </div>
                            </b-row>
                        </b-list-group-item>
                    </b-list-group>
                </b-row>
                <infinite-loading @infinite="infinitePageHandler" ref="infinitePageLoading">
                    <div slot="no-more">
                    </div>
                </infinite-loading>
            </template>
            <template v-else>
                <b-row>
                    <div class="col-md-12">
                        <b-row align-h="end">
                            <b-col cols="2" class="text-center" style="font-size:14px; color: black;">
                                Misc Page: &nbsp;&nbsp;
                                <hr class="mt-0">
                            </b-col>
                        </b-row>
                    </div>
                    <b-list-group class="col-md-6 pr-3 scope-list-group">
                        <b-list-group-item v-for="(scope, index) in leftMiscScopes" :key="index" class='p-0'>
                            <b-row class="m-0">
                                <div v-if="scope.is_header" class="bg-grey w-selected">X</div>
                                <div v-else class="w-selected">
                                    <b-form-checkbox v-model="scope.selected" value="1" unchecked-value="0" @change="updateScope(scope)"></b-form-checkbox>
                                </div>
                                <div :class="scope.is_header ? 'bg-grey w-service': 'w-service'">
                                    <b-form-input v-model="scope.service" @input="updateScope(scope)"></b-form-input>
                                </div>
                                <div v-if="scope.is_header" class="bg-grey w-uom">UOM</div>
                                <div v-else class="w-uom">
                                    <select v-model='scope.uom' class='form-control header-uom pt-0 pb-0' @change="updateScope(scope)">
                                        <option v-for='(title,index) in uoms' :key='index' :value='index'> {{title}}</option>
                                    </select>
                                </div>
                                <div v-if="scope.is_header" class="bg-grey w-qty">QTY</div>
                                <div v-else class="w-qty">
                                    <b-form-input v-model="scope.qty" @input="updateScope(scope)"></b-form-input>
                                </div>
                            </b-row>
                        </b-list-group-item>
                    </b-list-group>
                    <b-list-group class="col-md-6 pl-3 scope-list-group">
                        <b-list-group-item v-for="(scope, index) in rightMiscScopes" :key="index" class='p-0'>
                            <b-row class="m-0">
                                <div v-if="scope.is_header" class="bg-grey w-selected">X</div>
                                <div v-else class="w-selected">
                                    <b-form-checkbox v-model="scope.selected" value="1" unchecked-value="0" @change="updateScope(scope)"></b-form-checkbox>
                                </div>
                                <div :class="scope.is_header ? 'bg-grey w-service': 'w-service'">
                                    <b-form-input v-model="scope.service" @input="updateScope(scope)"></b-form-input>
                                </div>
                                <div v-if="scope.is_header" class="bg-grey w-uom">UOM</div>
                                <div v-else class="w-uom">
                                    <select v-model='scope.uom' class='form-control header-uom pt-0 pb-0' @change="updateScope(scope)">
                                        <option v-for='(title,index) in uoms' :key='index' :value='index'> {{title}}</option>
                                    </select>
                                </div>
                                <div v-if="scope.is_header" class="bg-grey w-qty">QTY</div>
                                <div v-else class="w-qty">
                                    <b-form-input v-model="scope.qty" @input="updateScope(scope)"></b-form-input>
                                </div>
                            </b-row>
                        </b-list-group-item>
                    </b-list-group>
                </b-row>
            </template>
        </div>
    </div>
</template>

<script type="text/babel">
    import InfiniteLoading from 'vue-infinite-loading'
    import apiProjectScope from '../../api/project_scope'
    import ErrorHandler from '../../mixins/error-handler'
    import Loading from '../layout/Loading'
    import _ from 'lodash'

    export default {
        mixins: [ErrorHandler],
        components: { Loading, InfiniteLoading },
        data() {
            return {
                tableCols: new Array(2),
                services: new Array(40),
                leftProjectScopes: [],
                rightProjectScopes: [],
                leftMiscScopes: [],
                rightMiscScopes: [],
                curPageNum: 0,
                maxPage: 0,
                isLoaded: false
            }
        },
        props: ['projectID', 'projectAreaID', 'uoms', 'miscScopes', 'isMisc'],
        created() {
            this.init()
        },
        methods: {
            init() {
                if (this.isMisc === '1') {
                    this.leftMiscScopes = []
                    this.rightMiscScopes = []
                    this.miscScopes.forEach((scope, index) => {
                        if (index < this.miscScopes.length / 2) {
                            this.leftMiscScopes.push(scope)
                        } else {
                            this.rightMiscScopes.push(scope)
                        }
                    })
                    this.isLoaded = true
                } else {
                    this.isLoaded = true
                }
            },
            infinitePageHandler($state) {
                this.fetchNextPageScopes()
            },
            fetchNextPageScopes() {
                this.curPageNum++

                return apiProjectScope.index({
                    project_id: this.projectID,
                    project_area_id: this.projectAreaID,
                    curPageNum: this.curPageNum
                }).then(res => {
                    this.maxPage = res.data.max_page
                    if (this.curPageNum > this.maxPage) {
                        this.curPageNum = this.maxPage
                        this.$refs.infinitePageLoading.$emit('$InfiniteLoading:complete')
                        return 1
                    }

                    let curPageScopes = res.data.cur_page_scopes
                    let leftPageScopes = []
                    let rightPageScopes = []
                    curPageScopes.forEach((scope, index) => {
                        if (index < curPageScopes.length / 2) {
                            leftPageScopes.push(scope)
                        } else {
                            rightPageScopes.push(scope)
                        }
                    })
                    this.leftProjectScopes.push(leftPageScopes)
                    this.rightProjectScopes.push(rightPageScopes)
                    this.$refs.infinitePageLoading.$emit('$InfiniteLoading:loaded')
                    return 0
                }).catch(this.handleErrorResponse)
            },
            updateScope: _.debounce(function(scope) {
                apiProjectScope.patch(scope.id, scope)
                .then(res => {
                }).catch(this.handleErrorResponse)
            }, 500)
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    @import "./scss/ScopeList.scss";    
</style>