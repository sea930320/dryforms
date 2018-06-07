<template>
    <div class="standards-scope-list">
        <b-row align-h="end">
            <b-col cols="2" class="text-center" style="font-size:14px; color: black;" v-if="pageIndex !== 'misc'">
                Page: {{pageIndex + 1}} &nbsp;&nbsp;
                <b-button v-if="pageCount !== 1" class='btn-remove-page' variant="danger" @click="deletePage" :disabled="isbusy">
                    <i class="fa fa-times" aria-hidden="true" style="cursor:pointer;"></i>
                </b-button>
                <hr class="mt-0">
            </b-col>
            <b-col v-else cols="2" class="text-center" style="font-size:14px; color: black;">
                Misc Page <hr class="mt-0">
            </b-col>
        </b-row>
        <b-row class="mt-1 mb-3 ml-0 mr-0">
            <b-list-group class="col-md-6 draggable pr-3">
                <draggable v-model="leftPageScopes" :options="{group:'project'}" @start="dragging = true" @end="updateOrder()" @add="added" @remove="removed">
                <transition-group name="list-complete">           
                    <b-list-group-item v-for="(item, index) in leftPageScopes" :key="index" class="list-complete-item row fr-box">
                        <div @mouseover="mouseOver(index, 'left')" @mouseleave="mouseLeave(index, 'left')">
                            <div class="fr-quick-insert" :class="item.hover?'fr-visible':''">
                                <a class="fr-floating-btn" role="button" tabindex="-1" @click="setHeader(index, 'left')">
                                    <i class="fa fa-header" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="fr-quick-insert fr-quick-right" :class="item.hover?'fr-visible':''">
                                <a class="fr-floating-btn" role="button" tabindex="-1" @click="removeItem(index, 'left')">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="row m-0">
                                <b-form-checkbox v-model="item.selected" value="1" unchecked-value="0" v-if="!item.is_header" @change="watchPendingBeforeScopeSave()"></b-form-checkbox>
                                <div v-else class="header-x text-center grey" :class="index>=noteRowStart?'note':''"> X </div>

                                <b-form-input v-model="item.service" :class="[item.is_header?'grey text-center header-service':'header-service', index>=noteRowStart?'note':'']" @input="watchPendingBeforeScopeSave()"></b-form-input>

                                <select v-if='!item.is_header' v-model='item.uom' class='form-control header-uom pt-0 pb-0' :class="index>=noteRowStart?'note':''" @change="watchPendingBeforeScopeSave()">
                                    <option v-for='(title,index) in uoms' :key='index' :value='index'> {{title}}</option>
                                </select>
                                <div v-else class="header-uom text-center grey" :class="index>=noteRowStart?'note':''"> UOM </div>

                                <b-form-input v-if="!item.is_header" v-model="item.qty" :class="['header-qty', index>=noteRowStart?'note':'']" @input="watchPendingBeforeScopeSave()"></b-form-input>
                                <div v-else class="header-qty text-center grey" :class="index>=noteRowStart?'note':''"> QTY </div>
                            </div>
                        </div>
                    </b-list-group-item>
                </transition-group>              
                </draggable>
            </b-list-group>
            <b-list-group class="col-md-6 draggable pl-3">
                <draggable v-model="rightPageScopes" :options="{group:'project'}" @start="dragging = true" @end="updateOrder()" @add="added()" @remove="removed()">
                <transition-group name="list-complete">
                    <b-list-group-item v-for="(item, index) in rightPageScopes" :key="index" class="list-complete-item row fr-box">
                    <div @mouseover="mouseOver(index, 'right')" @mouseleave="mouseLeave(index, 'right')">
                        <div class="fr-quick-insert" :class="item.hover?'fr-visible':''">
                        <a class="fr-floating-btn" role="button" tabindex="-1" @click="setHeader(index, 'right')">
                            <i class="fa fa-header" aria-hidden="true"></i>
                        </a>
                        </div>
                        <div class="fr-quick-insert fr-quick-right" :class="item.hover?'fr-visible':''">
                        <a class="fr-floating-btn" role="button" tabindex="-1" @click="removeItem(index, 'right')">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </a>
                        </div>
                        <div class="row m-0">
                            <b-form-checkbox v-model="item.selected" value="1" unchecked-value="0" v-if="!item.is_header" @change="watchPendingBeforeScopeSave()"> </b-form-checkbox>
                            <div v-else class="header-x text-center grey" :class="index+defLen/2>=noteRowStart?'note':''"> X </div>

                            <b-form-input v-model="item.service" :class="[item.is_header?'grey text-center header-service':'header-service', index+defLen/2>=noteRowStart?'note':'']" @input="watchPendingBeforeScopeSave()"></b-form-input>

                            <select v-if='!item.is_header' v-model='item.uom' class='form-control header-uom pt-0 pb-0' :class="index+defLen/2>=noteRowStart?'note':''" @change="watchPendingBeforeScopeSave()">
                            <option v-for='(title,index) in uoms' :key='index' :value='index'> {{title}}</option>
                            </select>
                            <div v-else class="header-uom text-center grey" :class="index+defLen/2>=noteRowStart?'note':''"> UOM </div>

                            <b-form-input v-if="!item.is_header" v-model="item.qty" :class="['header-qty', index+defLen/2>=noteRowStart?'note':'']" @input="watchPendingBeforeScopeSave()"></b-form-input>
                            <div v-else class="header-qty text-center grey" :class="index+defLen/2>=noteRowStart?'note':''"> QTY </div>
                        </div>
                    </div>
                    </b-list-group-item>
                </transition-group>
                </draggable>
            </b-list-group>
        </b-row>
    </div>
</template>

<script type="text/babel">
    import draggable from 'vuedraggable'
    import ErrorHandler from '../../mixins/error-handler'
    import InfiniteLoading from 'vue-infinite-loading'
    import apiStandardScope from '../../api/standard_scope'
    import apiStandardForm from '../../api/standard_form'
    import _ from 'lodash'

    export default {
        mixins: [ErrorHandler],
        name: 'standards-project-scope-list',
        components: { draggable, InfiniteLoading },
        data () {
            return {
                leftPageScopes: this.leftScope,
                rightPageScopes: this.rightScope,
                dragging: false,
                pending: false,
                log: {
                    time: null
                }
            }
        },
        props: ['leftScope', 'rightScope', 'uoms', 'pageIndex', 'pageCount', 'noteRowStart', 'defLen', 'form', 'isbusy'],
        created() {
            this.$parent.$on('updateList', () => {
                this.leftPageScopes = this.leftScope
                this.rightPageScopes = this.rightScope
            })
        },
        methods: {
            updateOrder() {
                this.dragging = false
                if (this.log.time && (new Date().getTime() - this.log.time) < 500) return
                this.watchPendingBeforePageSave()
            },
            added() {
                let totLength = this.leftPageScopes.length + this.rightPageScopes.length
                if (this.leftPageScopes.length < Math.ceil(totLength / 2)) {
                    let fE = this.rightPageScopes.shift()
                    this.leftPageScopes.push(fE)
                }
                if (this.leftPageScopes.length > Math.ceil(totLength / 2)) {
                    let fE = this.leftPageScopes.pop()
                    this.rightPageScopes.unshift(fE)
                }
                this.log = {
                    time: new Date().getTime()
                }
                this.watchPendingBeforePageSave()
            },
            removed() {
                let totLength = this.leftPageScopes.length + this.rightPageScopes.length
                if (this.leftPageScopes.length < Math.ceil(totLength / 2)) {
                    let fE = this.rightPageScopes.shift()
                    this.leftPageScopes.push(fE)
                }
                if (this.leftPageScopes.length > Math.ceil(totLength / 2)) {
                    let fE = this.leftPageScopes.pop()
                    this.rightPageScopes.unshift(fE)
                }
                if (this.log.time && (new Date().getTime() - this.log.time) < 500) return
                this.watchPendingBeforePageSave()
            },
            mouseOver(index, side) {
                if (side === 'left' && index >= this.leftPageScopes.length) return
                if (side === 'right' && index >= this.rightPageScopes.length) return
                if (this.dragging) {
                    if (side === 'left') {
                        this.$set(this.leftPageScopes[index], 'hover', false)
                    } else {
                        this.$set(this.rightPageScopes[index], 'hover', false)
                    }
                } else {
                    if (side === 'left') {
                        this.$set(this.leftPageScopes[index], 'hover', true)
                    } else {
                        this.$set(this.rightPageScopes[index], 'hover', true)
                    }
                }
            },
            mouseLeave(index, side) {
                if (side === 'left' && index >= this.leftPageScopes.length) return
                if (side === 'right' && index >= this.rightPageScopes.length) return
                if (side === 'left') {
                    this.$set(this.leftPageScopes[index], 'hover', false)
                } else {
                    this.$set(this.rightPageScopes[index], 'hover', false)
                }
            },
            setHeader(index, side) {
                this.removeItem(index, side)
                if (side === 'left') {
                    if (this.leftPageScopes[index].is_header) {
                        this.$set(this.leftPageScopes[index], 'is_header', 0)
                    } else {
                        this.$set(this.leftPageScopes[index], 'is_header', 1)
                    }
                } else {
                    if (this.rightPageScopes[index].is_header) {
                        this.$set(this.rightPageScopes[index], 'is_header', 0)
                    } else {
                        this.$set(this.rightPageScopes[index], 'is_header', 1)
                    }
                }
                this.watchPendingBeforeScopeSave()
            },
            removeItem(index, side) {
                if (side === 'left') {
                    this.$set(this.leftPageScopes[index], 'service', '')
                    this.$set(this.leftPageScopes[index], 'qty', '')
                    this.$set(this.leftPageScopes[index], 'selected', 0)
                    this.$set(this.leftPageScopes[index], 'uom', 0)
                } else {
                    this.$set(this.rightPageScopes[index], 'service', '')
                    this.$set(this.rightPageScopes[index], 'qty', '')
                    this.$set(this.rightPageScopes[index], 'selected', 0)
                    this.$set(this.rightPageScopes[index], 'uom', 0)
                }
                this.watchPendingBeforeScopeSave()
            },
            deletePage() {
                this.$emit('deletePage', {
                    pageIndex: this.pageIndex
                })
            },
            watchPendingBeforePageSave: _.throttle(function() {
                let downCount = 15
                if (this.pending) {
                    var pendingCheck = setInterval(() => {
                        if (downCount < 0) {
                            clearInterval(pendingCheck)
                            // notifiy error
                        }
                        downCount--
                        if (!this.pending) {
                            clearInterval(pendingCheck)
                            this.saveScopes()
                        }
                    }, 100)
                } else {
                    this.saveScopes()
                }
            }, 300),
            watchPendingBeforeScopeSave: _.debounce(function() {
                let downCount = 15
                if (this.pending) {
                    var pendingCheck = setInterval(() => {
                        if (downCount < 0) {
                            clearInterval(pendingCheck)
                            // notifiy error
                        }
                        downCount--
                        if (!this.pending) {
                            clearInterval(pendingCheck)
                            this.saveScopes()
                        }
                    }, 100)
                } else {
                    this.saveScopes()
                }
            }, 200),
            saveScopes() {
                this.pending = true
                let pageIndex = this.pageIndex === 'misc' ? -1 : this.pageIndex
                let scopes = []
                let no = 0
                this.leftPageScopes.forEach((scope, index) => {
                    scope.page = pageIndex + 1
                    scope.no = ++no
                    scopes.push(scope)
                })
                this.rightPageScopes.forEach((scope, index) => {
                    scope.page = pageIndex + 1
                    scope.no = ++no
                    scopes.push(scope)
                })

                if (this.form.id) {
                    const apis = [
                        apiStandardScope.store({
                            scopes: scopes
                        }),
                        apiStandardForm.patch(this.form.id, this.form)
                    ]
                    Promise.all(apis)
                    .then(response => {
                        this.refreshPageScopes(response[0].data.scopes)
                        this.pending = false
                    }).catch(this.handleErrorResponse)
                } else {
                    const apis = [
                        apiStandardScope.store({
                            scopes: scopes
                        }),
                        apiStandardForm.store(this.form)
                    ]
                    Promise.all(apis)
                    .then(response => {
                        this.refreshPageScopes(response[0].data.scopes)
                        this.form.id = response[1].data.form.id
                        this.pending = false
                    }).catch(this.handleErrorResponse)
                }
            },
            refreshPageScopes(scopes) {
                let length = scopes.length
                for (let i = 0; i < length; i++) {
                    if (i < this.leftPageScopes.length) {
                        this.leftPageScopes[i].id = scopes[i].id
                    } else {
                        this.rightPageScopes[i - this.leftPageScopes.length].id = scopes[i].id
                    }
                }
                this.$emit('changed', {
                    pageIndex: this.pageIndex,
                    leftPageScopes: this.leftPageScopes,
                    rightPageScopes: this.rightPageScopes
                })
            }
        },
        watch: {
            leftScope: function(newVal, oldVal) {
                if (!oldVal) this.leftPageScopes = newVal
            },
            rightScope: function(newVal, oldVal) {
                if (!oldVal) this.rightPageScopes = newVal
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    @import "./scss/ScopeList.scss";
</style>