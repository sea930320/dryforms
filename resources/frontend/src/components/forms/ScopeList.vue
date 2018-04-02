<template>
    <div>
        <b-row v-for="(page_index) in _.range(curPageNum)" :key="page_index">
            <div class="col-md-12">
                <b-row align-h="end">
                    <b-col cols="2" class="text-center" style="font-size:14px; color: black;">
                        Page: {{page_index + 1}} &nbsp;&nbsp;
                        <hr class="mt-0">
                    </b-col>
                </b-row>
            </div>
            <div class="col-md-6">
                <table class="text-center table-striped table">
                    <tr v-for="(scope, index) in leftProjectScopes[page_index]" :key="index">
                        <td v-if="scope.is_header" class="bg-grey w-10">X</td>
                        <td v-else class="w-10">
                            <i class="fa fa-check" v-if="scope.selected" aria-hidden="true"></i>
                        </td>

                        <td :class="scope.is_header ? 'bg-grey w-50': 'w-50'">{{scope.service}}</td>

                        <td v-if="scope.is_header" class="bg-grey w-20">UOM</td>
                        <td v-else class="w-20">
                            {{scope.uom_info ? scope.uom_info.title: ''}}
                        </td>

                        <td v-if="scope.is_header" class="bg-grey w-20">QTY</td>
                        <td v-else class="w-20">
                            {{scope.qty}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="text-center table-striped table">
                    <tr v-for="(scope, index) in rightProjectScopes[page_index]" :key="index">
                        <td v-if="scope.is_header" class="bg-grey w-10">X</td>
                        <td v-else class="w-10">
                            <i class="fa fa-check" v-if="scope.selected" aria-hidden="true"></i>
                        </td>

                        <td :class="scope.is_header ? 'bg-grey w-50': 'w-50'">{{scope.service}}</td>

                        <td v-if="scope.is_header" class="bg-grey w-20">UOM</td>
                        <td v-else class="w-20">
                            {{scope.uom_info ? scope.uom_info.title: ''}}
                        </td>

                        <td v-if="scope.is_header" class="bg-grey w-20">QTY</td>
                        <td v-else class="w-20">
                            {{scope.qty}}
                        </td>
                    </tr>
                </table>
            </div>
        </b-row>
        <infinite-loading @infinite="infinitePageHandler" ref="infinitePageLoading">
            <div slot="no-more">
            </div>
        </infinite-loading>
    </div>
</template>

<script type="text/babel">
    import InfiniteLoading from 'vue-infinite-loading'

    export default {
        components: { InfiniteLoading },
        data() {
            return {
                tableCols: new Array(2),
                services: new Array(40),
                leftProjectScopes: [],
                rightProjectScopes: [],
                curPageNum: 0
            }
        },
        props: ['projectScopes'],
        created() {
            this.leftProjectScopes = []
            this.rightProjectScopes = []
            this.projectScopes.forEach(pageScopes => {
                let leftPageScopes = []
                let rightPageScopes = []
                let length = pageScopes.length
                pageScopes.forEach((scope, index) => {
                    if (index < length / 2) {
                        leftPageScopes.push(scope)
                    } else {
                        rightPageScopes.push(scope)
                    }
                })
                this.leftProjectScopes.push(leftPageScopes)
                this.rightProjectScopes.push(rightPageScopes)
            })
        },
        methods: {
            infinitePageHandler($state) {
                this.fetchNextPageScopes()
            },
            fetchNextPageScopes() {
                this.curPageNum++
                if (this.curPageNum > this.projectScopes.length - 1) {
                    this.$refs.infinitePageLoading.$emit('$InfiniteLoading:complete')
                } else {
                    this.$refs.infinitePageLoading.$emit('$InfiniteLoading:loaded')
                }
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss" scoped>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 3px;
        height: 31px;
    }

    table {
        input {
            text-align: center;
            width: 100%;
            background-color: transparent;
            border: none;
        }
    }

    .w-50 {
        width: 50%
    }

    .w-20 {
        width: 20%
    }

    .w-10 {
        width: 10%
    }

    .bg-grey {
        background-color: #c3c3c3;
    }
</style>