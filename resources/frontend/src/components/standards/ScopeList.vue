<template>
    <div class="standards-scope-list">
        <b-row align-h="end">
            <b-col cols="2" class="text-center" style="font-size:14px; color: black;" v-if="pageIndex !== 'misc'">
                Page: {{pageIndex + 1}} &nbsp;&nbsp;
                <i class="fa fa-times" aria-hidden="true" style="cursor:pointer;" @click="deletePage"></i>
                <hr class="mt-0">
            </b-col>
            <b-col v-else cols="2" class="text-center" style="font-size:14px; color: black;">
                Misc Page <hr class="mt-0">
            </b-col>
        </b-row>
        <b-row class="mt-1 mb-3 ml-0 mr-0" v-if="leftPageScopes.length > 0">
            <b-list-group class="col-md-6 draggable pr-3">
                <b-list-group-item class="list-complete-item row fr-box mb-2">
                <div class="header-x text-center header-background"> X </div>
                <div class="header-service text-center header-background"> Service </div>
                <div class="header-uom text-center header-background"> UOM </div>
                <div class="header-qty text-center header-background"> QTY </div>
                </b-list-group-item>
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
                            <b-form-checkbox v-model="item.selected" value="1" unchecked-value="0" v-if="!item.is_header"> </b-form-checkbox>
                            <div v-else class="header-x text-center grey" :class="index>=noteRowStart?'note':''"> X </div>

                            <b-form-input v-model="item.service" :class="[item.is_header?'grey text-center header-service':'header-service', index>=noteRowStart?'note':'']"></b-form-input>

                            <select v-if='!item.is_header' v-model='item.uom' class='form-control header-uom pt-0 pb-0' :class="index>=noteRowStart?'note':''">
                            <option v-for='(title,index) in uoms' :key='index' :value='index'> {{title}}</option>
                            </select>
                            <div v-else class="header-uom text-center grey" :class="index>=noteRowStart?'note':''"> UOM </div>

                            <b-form-input v-if="!item.is_header" v-model="item.qty" :class="['header-qty', index>=noteRowStart?'note':'']"></b-form-input>
                            <div v-else class="header-qty text-center grey" :class="index>=noteRowStart?'note':''"> QTY </div>
                        </div>
                    </div>
                    </b-list-group-item>
                </transition-group>              
                </draggable>
            </b-list-group>
            <b-list-group class="col-md-6 draggable pl-3">
                <b-list-group-item class="list-complete-item row fr-box mb-2">
                <div class="header-x text-center header-background"> X </div>
                <div class="header-service text-center header-background"> Service </div>
                <div class="header-uom text-center header-background"> UOM </div>
                <div class="header-qty text-center header-background"> QTY </div>
                </b-list-group-item>
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
                            <b-form-checkbox v-model="item.selected" value="1" unchecked-value="0" v-if="!item.is_header"> </b-form-checkbox>
                            <div v-else class="header-x text-center grey" :class="index+defLen/2>=noteRowStart?'note':''"> X </div>

                            <b-form-input v-model="item.service" :class="[item.is_header?'grey text-center header-service':'header-service', index+defLen/2>=noteRowStart?'note':'']"></b-form-input>

                            <select v-if='!item.is_header' v-model='item.uom' class='form-control header-uom pt-0 pb-0' :class="index+defLen/2>=noteRowStart?'note':''">
                            <option v-for='(title,index) in uoms' :key='index' :value='index'> {{title}}</option>
                            </select>
                            <div v-else class="header-uom text-center grey" :class="index+defLen/2>=noteRowStart?'note':''"> UOM </div>

                            <b-form-input v-if="!item.is_header" v-model="item.qty" :class="['header-qty', index+defLen/2>=noteRowStart?'note':'']"></b-form-input>
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

    export default {
        mixins: [ErrorHandler],
        name: 'standards-project-scope-list',
        components: { draggable, InfiniteLoading },
        data () {
            return {
                leftPageScopes: this.leftScope,
                rightPageScopes: this.rightScope,
                dragging: false
            }
        },
        props: ['leftScope', 'rightScope', 'uoms', 'pageIndex', 'noteRowStart', 'defLen'],
        methods: {
            updateOrder() {
                this.dragging = false
                this.$emit('changed', {
                    pageIndex: this.pageIndex,
                    leftPageScopes: this.leftPageScopes,
                    rightPageScopes: this.rightPageScopes
                })
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
                this.$emit('changed', {
                    pageIndex: this.pageIndex,
                    leftPageScopes: this.leftPageScopes,
                    rightPageScopes: this.rightPageScopes
                })
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
                this.$emit('changed', {
                    pageIndex: this.pageIndex,
                    leftPageScopes: this.leftPageScopes,
                    rightPageScopes: this.rightPageScopes
                })
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
            },
            deletePage() {
                this.$emit('deletePage', {
                    pageIndex: this.pageIndex
                })
            }
        },
        watch: {
            leftScope: function(val) {
                this.leftPageScopes = val
            },
            rightScope: function(val) {
                this.rightPageScopes = val
            }
        }
    }
</script>

<style type="text/css" lang="scss" rel="stylesheet/scss">
    @import "./scss/ScopeList.scss";
</style>